<?php

namespace App\Filament\Warehouse\Resources\Invoiceissues\Pages;

use App\Filament\Warehouse\Resources\Invoiceissues\InvoiceissueResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditInvoiceissue extends EditRecord
{
    protected static string $resource = InvoiceissueResource::class;

    protected function getHeaderActions(): array
    {
        return [
         //   ViewAction::make(),
         //   DeleteAction::make(),
        ];
    }
}
