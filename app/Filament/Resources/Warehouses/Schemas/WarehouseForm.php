<?php

namespace App\Filament\Resources\Warehouses\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WarehouseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Warehouse Information')
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                          TextInput::make('address')
                            ->required()
                            ->columnSpan(2),
                        TextInput::make('city')
                            ->required(),
                        TextInput::make('province')
                            ->required(),
                        TextInput::make('zip_code'),

                        TextInput::make('mobile_number'),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email(),

                    ])->columns(3),

            ]);
    }
}
