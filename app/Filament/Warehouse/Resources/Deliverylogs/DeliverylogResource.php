<?php

namespace App\Filament\Warehouse\Resources\Deliverylogs;

use App\Filament\Warehouse\Resources\Deliverylogs\Pages\CreateDeliverylog;
use App\Filament\Warehouse\Resources\Deliverylogs\Pages\EditDeliverylog;
use App\Filament\Warehouse\Resources\Deliverylogs\Pages\ListDeliverylogs;
use App\Filament\Warehouse\Resources\Deliverylogs\RelationManagers\TripinvoicesRelationManager;
use App\Filament\Warehouse\Resources\Deliverylogs\Schemas\DeliverylogForm;
use App\Filament\Warehouse\Resources\Deliverylogs\Tables\DeliverylogsTable;
use App\Models\Deliverylog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class DeliverylogResource extends Resource
{
    protected static ?string $model = Deliverylog::class;

    protected static ?string $navigationLabel = 'Hub Deliverylog';
  //  protected static string | BackedEnum | null $navigationIcon = Heroicon::Truck;
   protected static string | UnitEnum | null $navigationGroup = 'Hub';
    protected ?string $heading = 'Hub Deliverylog';

    protected static ?string $recordTitleAttribute = 'trip_number';

    public static function form(Schema $schema): Schema
    {
        return DeliverylogForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DeliverylogsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            TripinvoicesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDeliverylogs::route('/'),
            'create' => CreateDeliverylog::route('/create'),
            'edit' => EditDeliverylog::route('/{record}/edit'),
        ];
    }
}
