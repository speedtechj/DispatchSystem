<?php

namespace App\Filament\Warehouse\Resources\Whdeliverylogs\Pages;

use App\Filament\Warehouse\Resources\Whdeliverylogs\WhdeliverylogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWhdeliverylogs extends ListRecords
{
    protected static string $resource = WhdeliverylogResource::class;
     protected ?string $heading = 'WH Delivery Logs';
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label('Create WH Delivery Log')
            ->icon('heroicon-o-plus'),
        ];
    }
}
