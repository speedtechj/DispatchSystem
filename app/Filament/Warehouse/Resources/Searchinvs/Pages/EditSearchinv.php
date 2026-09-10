<?php

namespace App\Filament\Warehouse\Resources\Searchinvs\Pages;

use App\Filament\Warehouse\Resources\Searchinvs\SearchinvResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSearchinv extends EditRecord
{
    protected static string $resource = SearchinvResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
