<?php

namespace App\Filament\Resources\Invoiceissues\Pages;

use App\Filament\Resources\Invoiceissues\InvoiceissueResource;
use App\Services\AttachmentService;
use App\Services\EmailService;
use Filament\Notifications\Notification;
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
