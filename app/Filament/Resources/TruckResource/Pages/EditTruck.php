<?php

namespace App\Filament\Resources\TruckResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\TruckResource;
use Filament\Actions;
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
