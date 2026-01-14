<?php

namespace App\Filament\Company\Resources\DriverResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Company\Resources\DriverResource;
use App\Models\Workposition;

class CreateDriver extends CreateRecord
{
    protected static string $resource = DriverResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $panelcategory = Workposition::where('id', $data['workposition_id'])->first();
        $data['logistichub_id'] = Auth::user()->logistichub_id;
        $data['is_crew'] = true;
        $data['is_admin'] = false;
        $data['company_id'] = Auth::user()->company_id;
        $data['panelcategory_id'] =  $panelcategory->panelcategory_id;
       return $data;


    }

}
