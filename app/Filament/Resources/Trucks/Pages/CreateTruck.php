<?php

namespace App\Filament\Resources\Trucks\Pages;

use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Trucks\TruckResource;

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
