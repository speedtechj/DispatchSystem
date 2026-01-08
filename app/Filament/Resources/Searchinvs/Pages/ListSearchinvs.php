<?php

namespace App\Filament\Resources\Searchinvs\Pages;

use App\Filament\Resources\Searchinvs\SearchinvResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSearchinvs extends ListRecords
{
    protected static string $resource = SearchinvResource::class;

    protected function getHeaderActions(): array
    {
        return [
           // CreateAction::make(),
        ];
    }
}
