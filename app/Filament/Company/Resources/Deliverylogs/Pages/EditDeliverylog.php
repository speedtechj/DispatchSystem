<?php

namespace App\Filament\Company\Resources\Deliverylogs\Pages;

use App\Filament\Company\Resources\Deliverylogs\DeliverylogResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDeliverylog extends EditRecord
{
    protected static string $resource = DeliverylogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
