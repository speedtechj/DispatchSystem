<?php

namespace App\Filament\Resources\Truckcrews\Pages;

use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Truckcrews\TruckcrewResource;

class CreateTruckcrew extends CreateRecord
{
    protected static string $resource = TruckcrewResource::class;
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
