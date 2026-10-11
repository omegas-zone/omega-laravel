@php
    $host = parse_url($bookmark->url, PHP_URL_HOST);
@endphp

<div
    class="group flex items-center gap-2 rounded-lg px-3 py-1.5 hover:bg-gray-50 dark:hover:bg-white/5"
    style="margin-left: {{ $level * 1.5 }}rem"
>
    <div class="w-7 shrink-0"></div>

    <div class="flex h-5 w-5 shrink-0 items-center justify-center">
        @if ($host)
            <img
                src="https://www.google.com/s2/favicons?domain={{ urlencode($host) }}&sz=32"
                alt=""
                width="16"
                height="16"
                class="h-4 w-4"
                loading="lazy"
            >
        @else
            <x-heroicon-o-link class="!h-4 !w-4 text-gray-400" />
        @endif
    </div>

    <div class="min-w-0 flex-1">
        <a
            href="{{ $bookmark->url }}"
            target="_blank"
            rel="noopener noreferrer"
            class="block truncate text-sm text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400"
            title="{{ $bookmark->url }}"
        >
            {{ $bookmark->title ?: $bookmark->url }}
        </a>

        @if ($host)
            <div class="truncate text-xs text-gray-400 dark:text-gray-500">
                {{ $host }}
            </div>
        @endif
    </div>

    <div class="hidden shrink-0 items-center gap-1 group-hover:flex">
        <a
            href="{{ \App\Filament\Resources\BookmarkLinks\BookmarkLinkResource::getUrl('edit', ['record' => $bookmark]) }}"
            title="Edit bookmark"
            class="rounded-md p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-white/10 dark:hover:text-gray-200"
        >
            <x-heroicon-m-pencil-square class="!h-4 !w-4 bookmark-icon bookmark-icon-action" />
        </a>

        <button
            type="button"
            wire:click="deleteBookmark({{ $bookmark->id }})"
            wire:confirm="Delete '{{ addslashes($bookmark->title) }}'?"
            title="Delete bookmark"
            class="rounded-md p-1.5 text-gray-400 hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-500/10 dark:hover:text-red-400"
        >
            <x-heroicon-m-trash class="!h-4 !w-4 bookmark-icon bookmark-icon-action" />
        </button>
    </div>
</div>
