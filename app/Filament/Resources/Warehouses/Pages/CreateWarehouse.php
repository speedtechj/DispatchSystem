<?php

namespace App\Filament\Resources\Warehouses\Pages;

use App\Filament\Resources\Warehouses\WarehouseResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateWarehouse extends CreateRecord
{
    protected static string $resource = WarehouseResource::class;
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
