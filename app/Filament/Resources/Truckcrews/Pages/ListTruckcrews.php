<?php

namespace App\Filament\Resources\Truckcrews\Pages;

use App\Filament\Resources\Truckcrews\TruckcrewResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTruckcrews extends ListRecords
{
    protected static string $resource = TruckcrewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
