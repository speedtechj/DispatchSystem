<?php

namespace App\Filament\Resources\Unmanifesteds\Pages;

use App\Filament\Resources\Unmanifesteds\UnmanifestedResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewUnmanifested extends ViewRecord
{
    protected static string $resource = UnmanifestedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
