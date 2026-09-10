<?php

namespace App\Filament\Warehouse\Resources\Deliveryinvs\Pages;

use App\Filament\Warehouse\Resources\Deliveryinvs\DeliveryinvResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDeliveryinv extends ViewRecord
{
    protected static string $resource = DeliveryinvResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
