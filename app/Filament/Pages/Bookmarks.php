<?php

namespace App\Filament\Pages;

use App\Models\BookmarkFolder;
use App\Models\BookmarkLink;
use App\Services\BookmarkImporter;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Collection;

class Bookmarks extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-bookmark-square';

    protected static ?string $navigationLabel = 'Bookmarks';

    protected static ?string $title = 'Bookmarks';

    protected static ?int $navigationSort = 20;

    protected string $view = 'filament.pages.bookmarks';

    public function getFolderTree(): Collection
    {
        $folders = BookmarkFolder::query()
            ->with('bookmarkLinks')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return $this->buildBranch($folders, null);
    }

    protected function buildBranch(
        Collection $folders,
        ?int $parentId,
    ): Collection {
        return $folders
            ->where('parent_id', $parentId)
            ->map(function (BookmarkFolder $folder) use ($folders): BookmarkFolder {
                $children = $this->buildBranch($folders, $folder->id);

                $folder->setAttribute('tree_children', $children);
                $folder->setAttribute(
                    'tree_bookmark_count',
                    $folder->bookmarkLinks->count()
                        + $children->sum(
                            fn (BookmarkFolder $child): int =>
                                (int) $child->getAttribute('tree_bookmark_count')
                        ),
                );

                return $folder;
            })
            ->values();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('importBookmarks')
                ->label('Import bookmarks')
                ->icon('heroicon-o-arrow-up-tray')
                ->modalHeading('Import bookmarks')
                ->modalDescription(
                    'Select the HTML bookmark export you want to import.'
                )
                ->schema([
                    FileUpload::make('file')
                        ->label('Bookmark export')
                        ->required()
                        ->acceptedFileTypes([
                            'text/html',
                            'application/octet-stream',
                        ])
                        ->maxSize(10240)
                        ->storeFiles(false)
                        ->helperText(
                            'Export your bookmarks as an HTML file.'
                        ),
                ])
                ->action(function (array $data): void {
                    try {
                        $result = app(BookmarkImporter::class)
                            ->import($data['file']);

                        Notification::make()
                            ->title('Bookmarks imported')
                            ->body(sprintf(
                                '%d folders created, %d bookmarks imported, %d bookmarks skipped.',
                                $result['folders_created'],
                                $result['bookmarks_created'],
                                $result['bookmarks_skipped'],
                            ))
                            ->success()
                            ->send();
                    } catch (\Throwable $exception) {
                        report($exception);

                        Notification::make()
                            ->title('Bookmark import failed')
                            ->body($exception->getMessage())
                            ->danger()
                            ->send();
                    }
                }),

            Action::make('newFolder')
                ->label('New folder')
                ->icon('heroicon-o-folder-plus')
                ->schema([
                    TextInput::make('name')
                        ->label('Folder name')
                        ->required()
                        ->maxLength(255),

                    Select::make('parent_id')
                        ->label('Parent folder')
                        ->options(fn (): array => $this->getFolderOptions())
                        ->searchable()
                        ->nullable(),
                ])
                ->action(function (array $data): void {
                    $maxSortOrder = BookmarkFolder::query()
                        ->where('parent_id', $data['parent_id'] ?? null)
                        ->max('sort_order');

                    BookmarkFolder::create([
                        'name' => $data['name'],
                        'parent_id' => $data['parent_id'] ?? null,
                        'sort_order' => ($maxSortOrder ?? -1) + 1,
                    ]);

                    Notification::make()
                        ->title('Folder created')
                        ->success()
                        ->send();
                }),
        ];
    }

    protected function getFolderOptions(): array
    {
        $folders = BookmarkFolder::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return $this->flattenFolderOptions($folders);
    }

    protected function flattenFolderOptions(
        Collection $folders,
        ?int $parentId = null,
        string $prefix = '',
    ): array {
        $options = [];

        foreach ($folders->where('parent_id', $parentId) as $folder) {
            $options[$folder->id] = $prefix . $folder->name;

            $options += $this->flattenFolderOptions(
                $folders,
                $folder->id,
                $prefix . '— ',
            );
        }

        return $options;
    }

    public function deleteFolder(int $folderId): void
    {
        $folder = BookmarkFolder::findOrFail($folderId);

        if ($folder->children()->exists()) {
            Notification::make()
                ->title('Folder not deleted')
                ->body('Move or delete the child folders first.')
                ->warning()
                ->send();

            return;
        }

        $folder->delete();

        Notification::make()
            ->title('Folder deleted')
            ->success()
            ->send();
    }

    public function deleteBookmark(int $bookmarkId): void
    {
        BookmarkLink::findOrFail($bookmarkId)->delete();

        Notification::make()
            ->title('Bookmark deleted')
            ->success()
            ->send();
    }
}
