<?php

namespace App\Filament\Resources\TruckResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\TruckResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrucks extends ListRecords
{
    protected static string $resource = TruckResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
