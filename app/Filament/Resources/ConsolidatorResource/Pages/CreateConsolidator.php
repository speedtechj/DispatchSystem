<?php

namespace App\Filament\Resources\ConsolidatorResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ConsolidatorResource;

class CreateConsolidator extends CreateRecord
{
    protected static string $resource = ConsolidatorResource::class;
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
