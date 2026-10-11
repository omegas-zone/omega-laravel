<?php

namespace App\Filament\Resources\BookmarkLinks\Pages;

use App\Filament\Resources\BookmarkLinks\BookmarkLinkResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBookmarkLink extends EditRecord
{
    protected static string $resource = BookmarkLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
