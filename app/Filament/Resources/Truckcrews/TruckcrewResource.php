<?php

namespace App\Filament\Resources\Truckcrews;

use App\Filament\Resources\Truckcrews\Pages\CreateTruckcrew;
use App\Filament\Resources\Truckcrews\Pages\EditTruckcrew;
use App\Filament\Resources\Truckcrews\Pages\ListTruckcrews;
use App\Filament\Resources\Truckcrews\Schemas\TruckcrewForm;
use App\Filament\Resources\Truckcrews\Tables\TruckcrewsTable;
use App\Models\Truckcrew;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TruckcrewResource extends Resource
{
    protected static ?string $model = Truckcrew::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return TruckcrewForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TruckcrewsTable::configure($table);
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
            'index' => ListTruckcrews::route('/'),
            'create' => CreateTruckcrew::route('/create'),
            'edit' => EditTruckcrew::route('/{record}/edit'),
        ];
    }
}
