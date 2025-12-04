<?php

namespace App\Filament\Resources\Logistichubs;

use App\Filament\Resources\Logistichubs\Pages\CreateLogistichub;
use App\Filament\Resources\Logistichubs\Pages\EditLogistichub;
use App\Filament\Resources\Logistichubs\Pages\ListLogistichubs;
use App\Filament\Resources\Logistichubs\Schemas\LogistichubForm;
use App\Filament\Resources\Logistichubs\Tables\LogistichubsTable;
use App\Models\Logistichub;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LogistichubResource extends Resource
{
    protected static ?string $model = Logistichub::class;
    protected static string | UnitEnum | null $navigationGroup = 'Settings';


  //  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return LogistichubForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LogistichubsTable::configure($table);
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
            'index' => ListLogistichubs::route('/'),
            'create' => CreateLogistichub::route('/create'),
            'edit' => EditLogistichub::route('/{record}/edit'),
        ];
    }
}
