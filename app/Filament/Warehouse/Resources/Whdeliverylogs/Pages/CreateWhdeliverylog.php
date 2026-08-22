<?php

namespace App\Filament\Warehouse\Resources\Whdeliverylogs\Pages;

use App\Filament\Warehouse\Resources\Whdeliverylogs\WhdeliverylogResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateWhdeliverylog extends CreateRecord
{
    protected static string $resource = WhdeliverylogResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $data['user_id'] = Auth::id();
        $data['user_whid'] = Auth::user()->warehouse_id;

        return $data;

    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
