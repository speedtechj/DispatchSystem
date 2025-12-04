<?php

namespace App\Filament\Resources\Invoiceissues\Pages;

use App\Filament\Resources\Invoiceissues\InvoiceissueResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInvoiceissues extends ListRecords
{
    protected static string $resource = InvoiceissueResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         CreateAction::make(),
    //     ];
    // }
}
