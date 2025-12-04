<?php

namespace App\Filament\Resources\Logistichubs\Pages;

use App\Filament\Resources\Logistichubs\LogistichubResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLogistichubs extends ListRecords
{
    protected static string $resource = LogistichubResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
