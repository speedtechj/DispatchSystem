<?php

namespace App\Filament\Warehouse\Resources\Deliveryinvs\Pages;

use App\Filament\Warehouse\Resources\Deliveryinvs\DeliveryinvResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDeliveryinvs extends ListRecords
{
    protected static string $resource = DeliveryinvResource::class;

    protected function getHeaderActions(): array
    {
        return [
   //         CreateAction::make(),
        ];
    }
}
