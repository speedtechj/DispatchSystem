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
    public function getWidgetData(): array
    {
        return [
            'provinces' => array_values(array_filter(
                (array) data_get($this->tableFilters, 'receiver_province.values', [])
            )),

        ];
    }
}
