<?php

namespace App\Filament\Warehouse\Resources\Trucks\Pages;

use App\Filament\Warehouse\Resources\Trucks\TruckResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateTruck extends CreateRecord
{
    protected static string $resource = TruckResource::class;
     protected function mutateFormDataBeforeCreate(array $data): array
    {

        $data['user_id'] = Auth::id();
        $data['logistichub_id'] = Auth::user()->logistichub_id;
        return $data;

    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
