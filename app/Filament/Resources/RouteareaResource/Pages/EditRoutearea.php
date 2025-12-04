<?php

namespace App\Filament\Resources\RouteareaResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\RouteareaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRoutearea extends EditRecord
{
    protected static string $resource = RouteareaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
