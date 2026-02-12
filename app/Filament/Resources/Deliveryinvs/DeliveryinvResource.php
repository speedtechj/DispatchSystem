<?php

namespace App\Filament\Resources\Deliveryinvs;

use App\Filament\Resources\Deliveryinvs\Pages\CreateDeliveryinv;
use App\Filament\Resources\Deliveryinvs\Pages\EditDeliveryinv;
use App\Filament\Resources\Deliveryinvs\Pages\ListDeliveryinvs;
use App\Filament\Resources\Deliveryinvs\Pages\ViewDeliveryinv;
use App\Filament\Resources\Deliveryinvs\Schemas\DeliveryinvForm;
use App\Filament\Resources\Deliveryinvs\Schemas\DeliveryinvInfolist;
use App\Filament\Resources\Deliveryinvs\Tables\DeliveryinvsTable;
use App\Models\Deliveryinv;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DeliveryinvResource extends Resource
{
    protected static ?string $model = Deliveryinv::class;
protected static ?string $navigationLabel = 'Delivery Invoice';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'invoice';

    public static function form(Schema $schema): Schema
    {
        return DeliveryinvForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DeliveryinvInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DeliveryinvsTable::configure($table);
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
            'index' => ListDeliveryinvs::route('/'),
            'create' => CreateDeliveryinv::route('/create'),
            'view' => ViewDeliveryinv::route('/{record}'),
            'edit' => EditDeliveryinv::route('/{record}/edit'),
        ];
    }
}
