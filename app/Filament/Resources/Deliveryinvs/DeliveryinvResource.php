<?php

namespace App\Filament\Resources\Deliveryinvs;

use BackedEnum;
use Filament\Tables\Table;
use App\Models\Deliveryinv;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use App\Filament\Resources\Deliveryinvs\Pages\EditDeliveryinv;
use App\Filament\Resources\Deliveryinvs\Pages\Viewdeliveryinv;
use App\Filament\Resources\Deliveryinvs\Pages\ListDeliveryinvs;
use App\Filament\Resources\Deliveryinvs\Pages\CreateDeliveryinv;
use App\Filament\Resources\Deliveryinvs\Schemas\DeliveryinvForm;
use App\Filament\Resources\Deliveryinvs\Tables\DeliveryinvsTable;

class DeliveryinvResource extends Resource
{
    protected static ?string $model = Deliveryinv::class;

    protected static ?string $navigationLabel = 'Delivery Invoices';
 public static ?string $label = 'Delivery Invoices';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $recordTitleAttribute = 'invoice';

    public static function form(Schema $schema): Schema
    {
        return DeliveryinvForm::configure($schema);
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
           // 'edit' => EditDeliveryinv::route('/{record}/edit'),


        ];
    }
}
