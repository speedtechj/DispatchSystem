<?php

namespace App\Filament\Resources\Deliverylogs\Pages;

use App\Filament\Resources\Deliverylogs\DeliverylogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDeliverylogs extends ListRecords
{
    protected static string $resource = DeliverylogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
