<?php

namespace App\Filament\Warehouse\Resources\Truckteams\Pages;

use App\Filament\Warehouse\Resources\Truckteams\TruckteamResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTruckteam extends EditRecord
{
    protected static string $resource = TruckteamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
