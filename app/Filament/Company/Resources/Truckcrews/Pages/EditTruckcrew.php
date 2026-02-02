<?php

namespace App\Filament\Company\Resources\Truckcrews\Pages;

use App\Filament\Company\Resources\Truckcrews\TruckcrewResource;
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
