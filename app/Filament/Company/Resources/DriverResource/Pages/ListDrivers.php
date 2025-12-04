<?php

namespace App\Filament\Company\Resources\DriverResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Company\Resources\DriverResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDrivers extends ListRecords
{
    protected static string $resource = DriverResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
