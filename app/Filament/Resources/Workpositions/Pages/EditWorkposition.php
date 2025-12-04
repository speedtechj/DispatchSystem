<?php

namespace App\Filament\Resources\Workpositions\Pages;

use App\Filament\Resources\Workpositions\WorkpositionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWorkposition extends EditRecord
{
    protected static string $resource = WorkpositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
