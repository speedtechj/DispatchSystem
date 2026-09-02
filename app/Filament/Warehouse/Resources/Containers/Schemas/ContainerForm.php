<?php

namespace App\Filament\Warehouse\Resources\Containers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ContainerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('consolidator_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('container_no')
                    ->required(),
                TextInput::make('booking_no')
                    ->required(),
                TextInput::make('batch_no'),
                TextInput::make('batch_year'),
                Toggle::make('is_unloaded')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('seal_number')
                    ->required(),
                TextInput::make('size')
                    ->required(),
                TextInput::make('type')
                    ->required(),
                TextInput::make('total_boxes')
                    ->required()
                    ->numeric(),
                TextInput::make('note'),
                Textarea::make('container_picture')
                    ->columnSpanFull(),
                TextInput::make('warehouse_id')
                    ->numeric(),
            ]);
    }
}
