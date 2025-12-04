<?php

namespace App\Filament\Resources\Unmanifesteds;

use App\Filament\Resources\Unmanifesteds\Pages\CreateUnmanifested;
use App\Filament\Resources\Unmanifesteds\Pages\EditUnmanifested;
use App\Filament\Resources\Unmanifesteds\Pages\ListUnmanifesteds;
use App\Filament\Resources\Unmanifesteds\Pages\ViewUnmanifested;
use App\Filament\Resources\Unmanifesteds\Schemas\UnmanifestedForm;
use App\Filament\Resources\Unmanifesteds\Schemas\UnmanifestedInfolist;
use App\Filament\Resources\Unmanifesteds\Tables\UnmanifestedsTable;
use App\Models\Unmanifested;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UnmanifestedResource extends Resource
{
    protected static ?string $model = Unmanifested::class;
 public static ?string $label = 'Unmanifested';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Unmanifested';

    public static function form(Schema $schema): Schema
    {
        return UnmanifestedForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UnmanifestedInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UnmanifestedsTable::configure($table);
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
            'index' => ListUnmanifesteds::route('/'),
            'create' => CreateUnmanifested::route('/create'),
           // 'view' => ViewUnmanifested::route('/{record}'),
            'edit' => EditUnmanifested::route('/{record}/edit'),
        ];
    }
}
