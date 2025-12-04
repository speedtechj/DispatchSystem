<?php

namespace App\Filament\Company\Resources\DriverResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Company\Resources\DriverResource;

class CreateDriver extends CreateRecord
{
    protected static string $resource = DriverResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;
        $data['is_admin'] = false; // Set default value for is_admin
        $data['company_id'] = Auth::user()->company_id; // Set company_id from the authenticated user
        $data['panelcategory_id'] = 2; // Set
        // You can also add any other default values or transformations here
        dd($data);
        return $data;

    }

}
