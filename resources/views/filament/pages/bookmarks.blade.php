<x-filament-panels::page>
    <div class="space-y-2">
        @php
            $folders = $this->getFolderTree();
        @endphp

        @forelse ($folders as $folder)
            @include('filament.pages.partials.bookmark-folder', [
                'folder' => $folder,
                'level' => 0,
            ])
        @empty
            <x-filament::section>
                <div class="py-8 text-center">
                    <x-heroicon-o-bookmark-square class="mx-auto !h-12 !w-12 text-gray-400 dark:text-gray-500" />

                    <h3 class="mt-3 text-sm font-semibold text-gray-950 dark:text-white">
                        No bookmarks yet
                    </h3>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Import your bookmarks or create a folder to get started.
                    </p>
                </div>
            </x-filament::section>
        @endforelse
    </div>
</x-filament-panels::page>
