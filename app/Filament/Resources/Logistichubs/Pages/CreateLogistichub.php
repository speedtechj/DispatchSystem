<?php

namespace App\Filament\Resources\Logistichubs\Pages;

use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\Logistichubs\LogistichubResource;

class CreateLogistichub extends CreateRecord
{
    protected static string $resource = LogistichubResource::class;
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
