<?php

namespace App\Filament\Resources\ContainerResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\ContainerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContainer extends EditRecord
{
    protected static string $resource = ContainerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
