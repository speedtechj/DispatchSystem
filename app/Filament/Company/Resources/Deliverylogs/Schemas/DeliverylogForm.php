<?php

namespace App\Filament\Company\Resources\Deliverylogs\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;

class DeliverylogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('truck_id')
                    ->required()
                    ->label('Truck')
                    ->options(
                        \App\Models\Truck::query()
                            ->where('is_assigned', 0)
                            ->pluck('plate_no', 'id')
                    )
                    ->searchable()
                    ->preload(),
                TextInput::make('trip_day')
                    ->required()
                    ->numeric(),
                DatePicker::make('eta')
                    ->required(),
                DatePicker::make('departure_date')
                    ->required(),
                DatePicker::make('delivery_date'),
                TextInput::make('waybill_number'),
                Toggle::make('is_current')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
                
            ]);
    }
}
