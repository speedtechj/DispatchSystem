<?php

namespace App\Filament\Resources\ConsolidatorResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ConsolidatorResource;

class EditConsolidator extends EditRecord
{
    protected static string $resource = ConsolidatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
//     protected function mutateFormDataBeforeSave(array $data): array
// {
//     $data['user_id'] = Auth::id();
//     return $data;
// }
    
}
