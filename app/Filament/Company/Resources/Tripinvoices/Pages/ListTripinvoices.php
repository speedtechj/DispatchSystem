<?php

namespace App\Filament\Company\Resources\Tripinvoices\Pages;

use App\Filament\Company\Resources\Tripinvoices\TripinvoiceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTripinvoices extends ListRecords
{
    protected static string $resource = TripinvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
