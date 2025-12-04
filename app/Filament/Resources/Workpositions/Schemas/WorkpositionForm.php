<?php

namespace App\Filament\Resources\Workpositions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class WorkpositionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required(),
                TextInput::make('position_description')
                    ->required(),
                Textarea::make('note')
                    ->columnSpanFull(),
                
            ]);
    }
}
