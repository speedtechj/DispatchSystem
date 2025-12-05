<?php

namespace App\Filament\Resources\Deliverylogs;

use App\Filament\Resources\Deliverylogs\Pages\CreateDeliverylog;
use App\Filament\Resources\Deliverylogs\Pages\EditDeliverylog;
use App\Filament\Resources\Deliverylogs\Pages\ListDeliverylogs;
use App\Filament\Resources\Deliverylogs\RelationManagers\TripinvoicesRelationManager;
use App\Filament\Resources\Deliverylogs\Schemas\DeliverylogForm;
use App\Filament\Resources\Deliverylogs\Tables\DeliverylogsTable;
use App\Models\Deliverylog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DeliverylogResource extends Resource
{
    protected static ?string $model = Deliverylog::class;
    protected static ?string $navigationLabel = 'Trip Record';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTruck;

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
