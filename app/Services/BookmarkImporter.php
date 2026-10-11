<?php

namespace App\Services;

use App\Models\BookmarkLink;
use App\Models\BookmarkFolder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class BookmarkImporter
{
    /**
     * @return array{
     *     folders_created: int,
     *     bookmarks_created: int,
     *     bookmarks_skipped: int
     * }
     */
    public function import(UploadedFile $file): array
    {
        $contents = $file->get();

        if ($contents === false || trim($contents) === '') {
            throw new RuntimeException('The uploaded bookmark file is empty.');
        }

        return DB::transaction(function () use ($contents): array {
            return $this->parse($contents);
        });
    }

    /**
     * Parse a Chromium/Vivaldi Netscape bookmark export.
     *
     * The root <DL> is treated as a container and is never imported
     * as a folder. Every <H3> represents a folder and every <A>
     * represents a bookmark.
     *
     * @return array{
     *     folders_created: int,
     *     bookmarks_created: int,
     *     bookmarks_skipped: int
     * }
     */
    protected function parse(string $contents): array
    {
        $stats = [
            'folders_created' => 0,
            'bookmarks_created' => 0,
            'bookmarks_skipped' => 0,
        ];

        /*
         * The Netscape bookmark format is not quite valid HTML.
         * In particular, browsers commonly produce:
         *
         * <DT><H3>Folder</H3>
         * <DL><p>
         *     ...
         * </DL><p>
         *
         * Instead of asking DOMDocument to interpret this as normal
         * HTML, tokenize the structure ourselves.
         */

        $tokens = $this->tokenize($contents);

        /*
         * Folder stack.
         *
         * The root <DL> is not represented here.
         */
        $folderStack = [];

        /*
         * When we encounter:
         *
         * <H3>Folder</H3>
         * <DL>
         *
         * we create the folder when the <DL> opens.
         */
        $pendingFolder = null;

        /*
         * Number of <DL> elements encountered.
         *
         * The first one is the root container.
         */
        $directoryDepth = 0;

        foreach ($tokens as $token) {
            switch ($token['type']) {
                case 'dl_open':
                    $directoryDepth++;

                    /*
                     * The first <DL> is the root container.
                     */
                    if ($directoryDepth === 1) {
                        $pendingFolder = null;

                        break;
                    }

                    /*
                     * A nested <DL> following an H3 means that
                     * the H3 represents a folder.
                     */
                    if ($pendingFolder !== null) {
                        $parentId = empty($folderStack)
                            ? null
                            : end($folderStack);

                        $folder = BookmarkFolder::query()
                            ->where('parent_id', $parentId)
                            ->where('name', $pendingFolder)
                            ->first();

                        if ($folder === null) {
                            $folder = BookmarkFolder::create([
                                'parent_id' => $parentId,
                                'name' => $pendingFolder,
                                'sort_order' => $this->nextFolderSortOrder(
                                    $parentId
                                ),
                            ]);

                            $stats['folders_created']++;
                        }

                        $folderStack[] = $folder->id;

                        $pendingFolder = null;
                    }

                    break;

                case 'dl_close':
                    /*
                     * The root <DL> doesn't correspond to a folder.
                     */
                    if ($directoryDepth > 1 && ! empty($folderStack)) {
                        array_pop($folderStack);
                    }

                    $directoryDepth--;

                    $pendingFolder = null;

                    break;

                case 'folder':
                    $pendingFolder = $token['name'];

                    break;

                case 'bookmark':
                    /*
                     * Bookmarks must belong to a folder.
                     *
                     * If the export contains a root-level bookmark,
                     * we currently ignore it because our data model
                     * requires every bookmark to have a folder.
                     */
                    if (empty($folderStack)) {
                        continue 2;
                    }

                    $folderId = end($folderStack);

                    $url = $token['url'];

                    /*
                     * The same URL is allowed in multiple folders,
                     * but not twice in the same folder.
                     */
                    $exists = BookmarkLink::query()
                        ->where('bookmark_folder_id', $folderId)
                        ->where('url', $url)
                        ->exists();

                    if ($exists) {
                        $stats['bookmarks_skipped']++;

                        continue 2;
                    }

                    BookmarkLink::create([
                        'bookmark_folder_id' => $folderId,
                        'title' => $token['title'] !== ''
                            ? $token['title']
                            : $url,
                        'url' => $url,
                        'description' => null,
                        'sort_order' => $this->nextBookmarkSortOrder(
                            $folderId
                        ),
                    ]);

                    $stats['bookmarks_created']++;

                    break;
            }
        }

        if (
            $stats['folders_created'] === 0 &&
            $stats['bookmarks_created'] === 0 &&
            $stats['bookmarks_skipped'] === 0
        ) {
            throw new RuntimeException(
                'No bookmarks or folders were found in the uploaded file.'
            );
        }

        return $stats;
    }

    /**
     * Convert the Netscape bookmark HTML into meaningful tokens.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function tokenize(string $contents): array
    {
        $tokens = [];

        /*
         * Folder:
         *
         * <H3>Folder name</H3>
         */
        preg_match_all(
            '/<H3\b[^>]*>(.*?)<\/H3>/is',
            $contents,
            $folders,
            PREG_OFFSET_CAPTURE
        );

        /*
         * Bookmark:
         *
         * <A HREF="..." ...>Title</A>
         */
        preg_match_all(
            '/<A\b([^>]*)>(.*?)<\/A>/is',
            $contents,
            $bookmarks,
            PREG_OFFSET_CAPTURE
        );

        /*
         * Directory opening/closing tags.
         */
        preg_match_all(
            '/<\/?DL\b[^>]*>/i',
            $contents,
            $directories,
            PREG_OFFSET_CAPTURE
        );

        foreach ($folders[0] as $index => $match) {
            $tokens[] = [
                'position' => $match[1],
                'type' => 'folder',
                'name' => $this->decodeHtml($folders[1][$index][0]),
            ];
        }

        foreach ($bookmarks[0] as $index => $match) {
            $attributes = $bookmarks[1][$index][0];

            $url = $this->extractHref($attributes);

            if ($url === '') {
                continue;
            }

            $tokens[] = [
                'position' => $match[1],
                'type' => 'bookmark',
                'url' => $url,
                'title' => $this->decodeHtml($bookmarks[2][$index][0]),
            ];
        }

        foreach ($directories[0] as $match) {
            $tag = strtolower($match[0]);

            $tokens[] = [
                'position' => $match[1],
                'type' => str_starts_with($tag, '</')
                    ? 'dl_close'
                    : 'dl_open',
            ];
        }

        usort(
            $tokens,
            fn (array $a, array $b): int => $a['position'] <=> $b['position']
        );

        return $tokens;
    }

    protected function extractHref(string $attributes): string
    {
        if (
            preg_match(
                '/\bHREF\s*=\s*(["\'])(.*?)\1/is',
                $attributes,
                $match
            )
        ) {
            return trim($this->decodeHtml($match[2]));
        }

        return '';
    }

    protected function decodeHtml(string $value): string
    {
        return trim(
            html_entity_decode(
                strip_tags($value),
                ENT_QUOTES | ENT_HTML5,
                'UTF-8'
            )
        );
    }

    protected function nextFolderSortOrder(?int $parentId): int
    {
        return (int) BookmarkFolder::query()
            ->where('parent_id', $parentId)
            ->max('sort_order') + 1;
    }

    protected function nextBookmarkSortOrder(int $folderId): int
    {
        return (int) BookmarkLink::query()
            ->where('bookmark_folder_id', $folderId)
            ->max('sort_order') + 1;
    }
}
