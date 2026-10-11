<?php

namespace App\Filament\Resources\BookmarkFolders\Pages;

use App\Filament\Resources\BookmarkFolders\BookmarkFolderResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBookmarkFolder extends EditRecord
{
    protected static string $resource = BookmarkFolderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
