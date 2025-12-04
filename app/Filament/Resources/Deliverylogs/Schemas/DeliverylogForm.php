<?php

namespace App\Filament\Resources\Deliverylogs\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class DeliverylogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
               Select::make('truck_id')
                    ->label('Truck')
                    ->options(\App\Models\Truck::query()->pluck('plate_no', 'id'))
                    ->searchable()
                    ->preload(),
                TextInput::make('trip_day')
                    ->required()
                    ->numeric(),
                DatePicker::make('eta')
                    ->native(false)
                    ->closeOnDateSelection(true)
                    ->required(),
                DatePicker::make('departure_date')
                    ->native(false)
                    ->closeOnDateSelection(true)
                    ->required(),
                Select::make('assigned_to')
                    ->label('Assigned To')
                    ->options(\App\Models\Logistichub::query()->pluck('hub_name', 'id'))
                    ->searchable()
                    ->preload()
                    // ->afterStateUpdated(function (Get $get, Set $set, ?string $state, ?string $old){

                    // })
            ]);
    }
}
