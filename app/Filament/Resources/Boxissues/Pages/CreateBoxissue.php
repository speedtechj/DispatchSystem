<?php

namespace App\Filament\Resources\Boxissues\Pages;

use App\Filament\Resources\Boxissues\BoxissueResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBoxissue extends CreateRecord
{
    protected static string $resource = BoxissueResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
