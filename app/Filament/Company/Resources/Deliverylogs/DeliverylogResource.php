<?php

namespace App\Filament\Company\Resources\Deliverylogs;

use App\Filament\Company\Resources\Deliverylogs\Pages\CreateDeliverylog;
use App\Filament\Company\Resources\Deliverylogs\Pages\EditDeliverylog;
use App\Filament\Company\Resources\Deliverylogs\Pages\ListDeliverylogs;
use App\Filament\Company\Resources\Deliverylogs\RelationManagers\TripinvoicesRelationManager as RelationManagersTripinvoicesRelationManager;
use App\Filament\Company\Resources\Deliverylogs\Schemas\DeliverylogForm;
use App\Filament\Company\Resources\Deliverylogs\Tables\DeliverylogsTable;
use App\Filament\Company\Resources\Tripinvoices\Schemas\TripinvoiceForm;
use App\Filament\Resources\Deliverylogs\RelationManagers\TripinvoicesRelationManager;
use App\Models\Deliverylog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DeliverylogResource extends Resource
{
    protected static ?string $model = Deliverylog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

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
           RelationManagersTripinvoicesRelationManager::class,
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
