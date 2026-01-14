<?php

namespace App\Filament\Company\Resources\Trucks\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TruckForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('category')
                    ->required(),
                TextInput::make('description')
                    ->required(),
                TextInput::make('registration_no')
                    ->required(),
                TextInput::make('plate_no')
                    ->required(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                DatePicker::make('date_registered')
                    ->required(),
                DatePicker::make('date_expired')
                    ->required(),
                Textarea::make('truck_picture')
                    ->columnSpanFull(),
                TextInput::make('logistichub_id')
                    ->required()
                    ->numeric(),
                Textarea::make('Note')
                    ->columnSpanFull(),
                Toggle::make('is_assigned')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
