<?php

namespace App\Filament\Resources\Inventories\Pages;

use App\Filament\Resources\Inventories\InventoryResource;
use App\Filament\Resources\Inventories\Widgets\InvetoryAllWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInventories extends ListRecords
{
    protected static string $resource = InventoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
      //      CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            InvetoryAllWidget::class,
        ];
    }
}
