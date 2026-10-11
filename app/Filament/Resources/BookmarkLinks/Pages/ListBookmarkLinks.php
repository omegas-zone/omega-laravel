<?php

namespace App\Filament\Resources\BookmarkLinks\Pages;

use App\Filament\Resources\BookmarkLinks\BookmarkLinkResource;
use App\Services\BookmarkImporter;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListBookmarkLinks extends ListRecords
{
    protected static string $resource = BookmarkLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('importBookmarks')
                ->label('Import bookmarks')
                ->icon('heroicon-o-arrow-up-tray')
                ->modalHeading('Import bookmarks')
                ->modalDescription(
                    'Select the HTML bookmark export.'
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

            // Your existing CreateAction, etc.
        ];
    }
}
