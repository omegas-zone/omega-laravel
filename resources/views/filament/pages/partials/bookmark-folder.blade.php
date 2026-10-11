@php
    $folderId = 'bookmark-folder-' . $folder->id;
@endphp

<div
    x-data="{ open: false }"
    class="group"
>
    <div
        class="flex items-center gap-2 rounded-lg px-3 py-2 transition hover:bg-gray-50 dark:hover:bg-white/5"
        style="padding-left: {{ $level * 1.5 + 0.75 }}rem"
    >
        <button
            type="button"
            x-on:click="open = !open"
            class="flex h-7 w-7 shrink-0 items-center justify-center rounded-md text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/10 dark:hover:text-gray-200"
            aria-label="Toggle folder"
        >
            <x-heroicon-o-chevron-right x-show="!open" class="bookmark-icon bookmark-icon-chevron" />
            <x-heroicon-o-chevron-down x-show="open" class="bookmark-icon bookmark-icon-chevron" />
        </button>

        <x-heroicon-o-folder class="bookmark-icon bookmark-icon-folder text-amber-500" />

        <a
            href="{{ \App\Filament\Resources\BookmarkFolders\BookmarkFolderResource::getUrl('edit', ['record' => $folder]) }}"
            class="min-w-0 flex-1 truncate text-sm font-medium text-gray-950 hover:text-primary-600 dark:text-white dark:hover:text-primary-400"
        >
            {{ $folder->name }}
        </a>

        <span class="text-xs text-gray-400 dark:text-gray-500">
            {{ $folder->tree_bookmark_count }}
        </span>

        <div class="hidden shrink-0 items-center gap-1 group-hover:flex">
            <a
                href="{{ \App\Filament\Resources\BookmarkFolders\BookmarkFolderResource::getUrl('edit', ['record' => $folder]) }}"
                title="Edit folder"
                class="rounded-md p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-white/10 dark:hover:text-gray-200"
            >
                <x-heroicon-m-pencil-square class="bookmark-icon bookmark-icon-action" />
            </a>

            @if ($folder->tree_children->isEmpty())
                <button
                    type="button"
                    wire:click="deleteFolder({{ $folder->id }})"
                    wire:confirm="Delete the folder '{{ addslashes($folder->name) }}'?"
                    title="Delete folder"
                    class="rounded-md p-1.5 text-gray-400 hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-500/10 dark:hover:text-red-400"
                >
                    <x-heroicon-m-trash class="bookmark-icon bookmark-icon-action" />
                </button>
            @endif
        </div>
    </div>

    <div
        x-show="open"
        x-collapse.duration.150ms
        id="{{ $folderId }}"
    >
        @foreach ($folder->bookmarkLinks as $bookmark)
            @include('filament.pages.partials.bookmark-link', [
                'bookmark' => $bookmark,
                'level' => $level + 1,
            ])
        @endforeach

        @foreach ($folder->tree_children as $child)
            @include('filament.pages.partials.bookmark-folder', [
                'folder' => $child,
                'level' => $level + 1,
            ])
        @endforeach
    </div>
</div>
