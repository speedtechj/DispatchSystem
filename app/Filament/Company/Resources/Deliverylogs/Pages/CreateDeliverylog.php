<?php

namespace App\Filament\Company\Resources\Deliverylogs\Pages;

use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Company\Resources\Deliverylogs\DeliverylogResource;

class CreateDeliverylog extends CreateRecord
{
    protected static string $resource = DeliverylogResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['logistichub_id'] = Auth::user()->logistichub_id;
        $data['user_id'] = Auth::id();
        $data['assigned_to'] = Auth::user()->logistichub_id;

        return $data;

    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
