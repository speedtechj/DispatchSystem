<?php

namespace App\Filament\Resources\Workpositions\Pages;

use App\Filament\Resources\Workpositions\WorkpositionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWorkpositions extends ListRecords
{
    protected static string $resource = WorkpositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
