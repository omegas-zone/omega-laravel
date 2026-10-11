<?php

namespace App\Filament\Resources\BookmarkFolders;

use Alareqi\FilamentTree\Columns\TreeColumn;
use App\Filament\Resources\BookmarkFolders\Pages\CreateBookmarkFolder;
use App\Filament\Resources\BookmarkFolders\Pages\EditBookmarkFolder;
use App\Filament\Resources\BookmarkFolders\Pages\ListBookmarkFolders;
use App\Models\BookmarkFolder;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class BookmarkFolderResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-bookmark-square';

    protected static ?string $navigationLabel = 'Bookmarks';

    protected static ?string $modelLabel = 'bookmark folder';

    protected static ?string $pluralModelLabel = 'bookmark_links';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TreeColumn::make('name')
                    ->label('Folder')
                    ->searchable(),
            ])
            ->reorderable('sort_order')
            ->tree(
                parentColumn: 'parent_id',
                treeColumn: 'name',
            );
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookmarkFolders::route('/'),
            'create' => CreateBookmarkFolder::route('/create'),
            'edit' => EditBookmarkFolder::route('/{record}/edit'),
        ];
    }
}
