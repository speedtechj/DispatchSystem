<?php

namespace App\Filament\Warehouse\Resources\Invoiceissues\Pages;

use App\Filament\Warehouse\Resources\Invoiceissues\InvoiceissueResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewInvoiceissue extends ViewRecord
{
    protected static string $resource = InvoiceissueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
