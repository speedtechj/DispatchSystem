<?php

namespace App\Filament\Resources\Invoiceissues\Pages;

use App\Filament\Resources\Invoiceissues\InvoiceissueResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInvoiceissue extends EditRecord
{
    protected static string $resource = InvoiceissueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
