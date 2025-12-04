<?php

namespace App\Filament\Resources\RouteareaResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\RouteareaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRouteareas extends ListRecords
{
    protected static string $resource = RouteareaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
