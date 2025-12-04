<?php

namespace App\Filament\Resources\Unmanifesteds\Pages;

use App\Filament\Resources\Unmanifesteds\UnmanifestedResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditUnmanifested extends EditRecord
{
    protected static string $resource = UnmanifestedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
