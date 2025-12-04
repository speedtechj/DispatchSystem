<?php

namespace App\Filament\Resources\Logistichubs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LogistichubForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('hub_code')
                    ->required(),
                TextInput::make('hub_name')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('is_company')
                    ->required(),
                
            ]);
    }
}
