<?php

namespace App\Filament\Resources\TruckResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\TruckResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTruck extends CreateRecord
{
    protected static string $resource = TruckResource::class;
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
