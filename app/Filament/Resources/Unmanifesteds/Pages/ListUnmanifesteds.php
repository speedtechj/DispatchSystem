<?php

namespace App\Filament\Resources\Unmanifesteds\Pages;

use App\Filament\Resources\Unmanifesteds\UnmanifestedResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUnmanifesteds extends ListRecords
{
    protected static string $resource = UnmanifestedResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         CreateAction::make(),
    //     ];
    // }
}
