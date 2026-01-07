<?php

namespace App\Filament\Resources\Truckteams\Pages;

use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Truckteams\TruckteamResource;

class CreateTruckteam extends CreateRecord
{
    protected static string $resource = TruckteamResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        
       // $data['id'] = Auth::user()->id;
        $data['logistichub_id'] = Auth::user()->logistichub_id;
        $data['is_crew'] = true;
        $data['is_admin'] = false;
        $data['company_id'] = Auth::user()->company_id;
        $data['panelcategory_id'] = 3;

        return $data;

    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
