<?php

namespace App\Filament\Resources\Truckteams;

use App\Filament\Resources\Truckteams\Pages\CreateTruckteam;
use App\Filament\Resources\Truckteams\Pages\EditTruckteam;
use App\Filament\Resources\Truckteams\Pages\ListTruckteams;
use App\Filament\Resources\Truckteams\Schemas\TruckteamForm;
use App\Filament\Resources\Truckteams\Tables\TruckteamsTable;
use App\Models\Truckteam;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TruckteamResource extends Resource
{
    protected static ?string $model = Truckteam::class;
    protected static ?string $navigationLabel = 'Truck Teams';
    protected static string | UnitEnum | null $navigationGroup = 'Settings';
   // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return TruckteamForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TruckteamsTable::configure($table);
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
            'index' => ListTruckteams::route('/'),
            'create' => CreateTruckteam::route('/create'),
            'edit' => EditTruckteam::route('/{record}/edit'),
        ];
    }
}
