<?php

namespace App\Filament\Company\Resources\Trucks;

use BackedEnum;
use App\Models\Truck;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Filament\Company\Resources\Trucks\Pages\EditTruck;
use App\Filament\Company\Resources\Trucks\Pages\ListTrucks;
use App\Filament\Company\Resources\Trucks\Pages\CreateTruck;
use App\Filament\Company\Resources\Trucks\Schemas\TruckForm;
use App\Filament\Company\Resources\Trucks\Tables\TrucksTable;
use App\Filament\Company\Resources\Trucks\RelationManagers\TruckcrewsRelationManager;

class TruckResource extends Resource
{
    protected static ?string $model = Truck::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

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
            TruckcrewsRelationManager::class,
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
