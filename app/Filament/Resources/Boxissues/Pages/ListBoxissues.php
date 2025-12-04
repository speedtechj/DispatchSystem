<?php

namespace App\Filament\Resources\Boxissues\Pages;

use App\Filament\Resources\Boxissues\BoxissueResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBoxissues extends ListRecords
{
    protected static string $resource = BoxissueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
