<?php

namespace App\Filament\Resources\BookmarkLinks;

use App\Filament\Resources\BookmarkLinks\Pages\CreateBookmarkLink;
use App\Filament\Resources\BookmarkLinks\Pages\EditBookmarkLink;
use App\Filament\Resources\BookmarkLinks\Pages\ListBookmarkLinks;
use App\Filament\Resources\BookmarkLinks\Schemas\BookmarkLinkForm;
use App\Filament\Resources\BookmarkLinks\Tables\BookmarkLinksTable;
use App\Models\BookmarkLink;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BookmarkLinkResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $model = BookmarkLink::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-bookmark-square';

    protected static ?string $recordTitleAttribute = 'Link';

    public static function form(Schema $schema): Schema
    {
        return BookmarkLinkForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BookmarkLinksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookmarkLinks::route('/'),
            'create' => CreateBookmarkLink::route('/create'),
            'edit' => EditBookmarkLink::route('/{record}/edit'),
        ];
    }
}
