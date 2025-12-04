<?php

namespace App\Filament\Resources\Boxissues\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BoxissueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('issue_type')
                ->label('Issue Type'),
            ]);
    }
}
