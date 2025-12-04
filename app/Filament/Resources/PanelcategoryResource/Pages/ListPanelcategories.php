<?php

namespace App\Filament\Resources\PanelcategoryResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\PanelcategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPanelcategories extends ListRecords
{
    protected static string $resource = PanelcategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
