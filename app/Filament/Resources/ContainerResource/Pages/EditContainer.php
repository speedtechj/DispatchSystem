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

    protected function afterSave(): void
{

     if ($this->record->wasChanged('warehouse_id')) {
        $this->record->invoices()->update([
            'warehouse_id' => $this->record->warehouse_id,
        ]);
    }
}
}
