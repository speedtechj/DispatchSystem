<?php

namespace App\Filament\Resources\Truckteams\Pages;

use App\Filament\Resources\Truckteams\TruckteamResource;
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
     protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
