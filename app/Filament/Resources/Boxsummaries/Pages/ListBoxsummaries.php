<?php

namespace App\Filament\Resources\Boxsummaries\Pages;

use App\Filament\Resources\Boxsummaries\BoxsummaryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBoxsummaries extends ListRecords
{
    protected static string $resource = BoxsummaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
      //      CreateAction::make(),
        ];
    }
}
