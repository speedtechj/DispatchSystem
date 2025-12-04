<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use Illuminate\Support\Facades\Auth;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\CompanyResource;
use App\Models\Logistichub;

class CreateCompany extends CreateRecord
{
    protected static string $resource = CompanyResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        
        $data['user_id'] = Auth::id();

        return $data;

    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    
    protected function afterCreate(): void
    {
        Logistichub::where('id',$this->data['logistichub_id'])
        ->update([
            'is_assigned' => true,
        ]);
    }
}
