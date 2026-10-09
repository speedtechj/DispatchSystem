<?php

namespace App\Filament\Warehouse\Resources\Inventories\Pages;



use App\Filament\Warehouse\Resources\Inventories\InventoryResource;
use App\Filament\Warehouse\Resources\Inventories\Widgets\InventoryAllWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInventories extends ListRecords
{
    protected static string $resource = InventoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
    //        CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            InventoryAllWidget::class,
        ];
    }
}
