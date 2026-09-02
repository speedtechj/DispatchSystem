<?php

namespace App\Filament\Warehouse\Resources\Containers\Pages;

use App\Filament\Warehouse\Resources\Containers\ContainerResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewContainer extends ViewRecord
{
    protected static string $resource = ContainerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
