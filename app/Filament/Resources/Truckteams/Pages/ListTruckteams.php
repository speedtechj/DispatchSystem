<?php

namespace App\Filament\Resources\Truckteams\Pages;

use App\Filament\Resources\Truckteams\TruckteamResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTruckteams extends ListRecords
{
    protected static string $resource = TruckteamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label('Add New Crew'),
        ];
    }
}
