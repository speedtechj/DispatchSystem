<?php

namespace App\Filament\Warehouse\Resources\Whdeliverylogs\Pages;

use App\Filament\Warehouse\Resources\Whdeliverylogs\WhdeliverylogResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditWhdeliverylog extends EditRecord
{
    protected static string $resource = WhdeliverylogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeSave(array $data): array {
        $data['user_whid'] = Auth::user()->warehouse_id;

        return $data;

    }
    protected function getCancelFormAction(): Action
    {
        return Action::make('cancel')
            ->label('Cancel')
            ->url($this->getResource()::getUrl('index'))
            ->color('gray');
    }
}
