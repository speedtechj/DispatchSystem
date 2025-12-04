<?php

namespace App\Filament\Resources\Logistichubs\Pages;

use App\Filament\Resources\Logistichubs\LogistichubResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLogistichub extends EditRecord
{
    protected static string $resource = LogistichubResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
