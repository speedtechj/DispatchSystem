<?php

namespace App\Filament\Warehouse\Resources\Deliveryinvs\Pages;

use App\Filament\Warehouse\Resources\Deliveryinvs\DeliveryinvResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDeliveryinv extends EditRecord
{
    protected static string $resource = DeliveryinvResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
