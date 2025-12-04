<?php

namespace App\Filament\Resources\Invoiceissues\Pages;

use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Invoiceissues\InvoiceissueResource;

class CreateInvoiceissue extends CreateRecord
{
    protected static string $resource = InvoiceissueResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        
        $data['user_id'] = Auth::id();

        return $data;

    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
