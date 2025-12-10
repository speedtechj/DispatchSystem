<?php

namespace App\Filament\Resources\Deliveryinvs\Pages;

use App\Filament\Resources\Deliveryinvs\DeliveryinvResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDeliveryinv extends EditRecord
{
    protected static string $resource = DeliveryinvResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
