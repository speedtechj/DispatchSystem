<?php

namespace App\Filament\Resources\Deliveryinvs\Pages;

use App\Filament\Resources\Deliveryinvs\DeliveryinvResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDeliveryinv extends ViewRecord
{
    protected static string $resource = DeliveryinvResource::class;

    protected function getHeaderActions(): array
    {
        return [
       //     EditAction::make(),
        ];
    }
}
