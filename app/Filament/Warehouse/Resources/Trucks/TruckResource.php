<?php

namespace App\Filament\Warehouse\Resources\Trucks;

use App\Filament\Warehouse\Resources\Trucks\Pages\CreateTruck;
use App\Filament\Warehouse\Resources\Trucks\Pages\EditTruck;
use App\Filament\Warehouse\Resources\Trucks\Pages\ListTrucks;
use App\Filament\Warehouse\Resources\Trucks\Schemas\TruckForm;
use App\Filament\Warehouse\Resources\Trucks\Tables\TrucksTable;
use App\Models\Truck;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TruckResource extends Resource
{
    protected static ?string $model = Truck::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Truck;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return TruckForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TrucksTable::configure($table);
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
            'index' => ListTrucks::route('/'),
            'create' => CreateTruck::route('/create'),
            'edit' => EditTruck::route('/{record}/edit'),
        ];
    }
}
