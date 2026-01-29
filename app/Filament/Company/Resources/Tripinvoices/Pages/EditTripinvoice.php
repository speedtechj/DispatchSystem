<?php

namespace App\Filament\Company\Resources\Tripinvoices\Pages;

use App\Filament\Company\Resources\Tripinvoices\TripinvoiceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTripinvoice extends EditRecord
{
    protected static string $resource = TripinvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
