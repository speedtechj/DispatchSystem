<?php

namespace App\Filament\Warehouse\Resources\Deliveryinvs;

use App\Filament\Warehouse\Resources\Deliveryinvs\Pages\CreateDeliveryinv;
use App\Filament\Warehouse\Resources\Deliveryinvs\Pages\EditDeliveryinv;
use App\Filament\Warehouse\Resources\Deliveryinvs\Pages\ListDeliveryinvs;
use App\Filament\Warehouse\Resources\Deliveryinvs\Pages\ViewDeliveryinv;
use App\Filament\Warehouse\Resources\Deliveryinvs\Schemas\DeliveryinvForm;
use App\Filament\Warehouse\Resources\Deliveryinvs\Schemas\DeliveryinvInfolist;
use App\Filament\Warehouse\Resources\Deliveryinvs\Tables\DeliveryinvsTable;
use App\Models\Deliveryinv;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class DeliveryinvResource extends Resource
{
    protected static ?string $model = Deliveryinv::class;
     protected static string | UnitEnum | null $navigationGroup = 'Invoice Management';
    protected static ?string $navigationLabel = 'Delivery Invoice';
    public static ?string $label = 'Delivery Invoice';

  //  protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocumentCheck;

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
