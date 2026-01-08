<?php

namespace App\Filament\Resources\Searchinvs;

use App\Filament\Resources\Searchinvs\Pages\CreateSearchinv;
use App\Filament\Resources\Searchinvs\Pages\EditSearchinv;
use App\Filament\Resources\Searchinvs\Pages\ListSearchinvs;
use App\Filament\Resources\Searchinvs\Schemas\SearchinvForm;
use App\Filament\Resources\Searchinvs\Tables\SearchinvsTable;
use App\Models\Searchinv;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SearchinvResource extends Resource
{
    protected static ?string $model = Searchinv::class;
     protected static ?string $navigationLabel = 'Search Invoice';
    public static ?string $label = 'Serch Invoice';


    protected static string|BackedEnum|null $navigationIcon = Heroicon::MagnifyingGlass;

    protected static ?string $recordTitleAttribute = 'invoice';

    public static function form(Schema $schema): Schema
    {
        return SearchinvForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SearchinvsTable::configure($table);
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
            'index' => ListSearchinvs::route('/'),
            'create' => CreateSearchinv::route('/create'),
         //   'edit' => EditSearchinv::route('/{record}/edit'),
        ];
    }
}
