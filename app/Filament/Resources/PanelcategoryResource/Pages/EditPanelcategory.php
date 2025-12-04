<?php

namespace App\Filament\Resources\PanelcategoryResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\PanelcategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPanelcategory extends EditRecord
{
    protected static string $resource = PanelcategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
