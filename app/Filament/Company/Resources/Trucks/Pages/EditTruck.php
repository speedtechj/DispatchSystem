<?php

namespace App\Filament\Company\Resources\Trucks\Pages;

use App\Filament\Company\Resources\Trucks\TruckResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTruck extends EditRecord
{
    protected static string $resource = TruckResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
