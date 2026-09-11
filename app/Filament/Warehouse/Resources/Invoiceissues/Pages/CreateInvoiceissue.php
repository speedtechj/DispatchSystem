<?php

namespace App\Filament\Warehouse\Resources\Invoiceissues\Pages;

use App\Filament\Warehouse\Resources\Invoiceissues\InvoiceissueResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateInvoiceissue extends CreateRecord
{
    protected static string $resource = InvoiceissueResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
       // dd($data);
        $data['user_id'] = Auth::id();

        return $data;

    }
}
