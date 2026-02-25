<?php

namespace App\Filament\Resources\Deliveryinvs\Pages;

use App\Filament\Resources\Deliveryinvs\DeliveryinvResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDeliveryinvs extends ListRecords
{
    protected static string $resource = DeliveryinvResource::class;

    protected function getHeaderActions(): array
    {
        return [
        //    CreateAction::make(),
        ];
    }
}
