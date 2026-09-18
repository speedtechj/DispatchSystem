<?php

namespace App\Filament\Warehouse\Resources\Truckcrews\Pages;

use App\Filament\Warehouse\Resources\Truckcrews\TruckcrewResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTruckcrew extends EditRecord
{
    protected static string $resource = TruckcrewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
