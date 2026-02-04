<?php

namespace App\Filament\Resources\Boxsummaries\Pages;

use App\Filament\Resources\Boxsummaries\BoxsummaryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBoxsummary extends EditRecord
{
    protected static string $resource = BoxsummaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
