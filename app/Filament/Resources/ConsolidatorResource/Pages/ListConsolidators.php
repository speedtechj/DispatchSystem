<?php

namespace App\Filament\Resources\ConsolidatorResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Actions;
use Livewire\Attributes\On;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\ConsolidatorForm;
use App\Filament\Resources\ConsolidatorResource;

class ListConsolidators extends ListRecords
{
    protected static string $resource = ConsolidatorResource::class;
    // #[On('refresh-consolidator-table')]
    // public function refreshtable(){

    // }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
    // protected function getHeaderWidgets(): array {

    //     return [
    //             ConsolidatorForm::class
    //     ];

    // }
}
