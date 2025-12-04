<?php

namespace App\Filament\Resources\Boxissues\Pages;

use App\Filament\Resources\Boxissues\BoxissueResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBoxissue extends EditRecord
{
    protected static string $resource = BoxissueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
