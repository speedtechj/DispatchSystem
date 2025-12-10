<?php

namespace App\Filament\Resources\Deliveryinvs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DeliveryinvForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('invoice')
                    ->required(),
                TextInput::make('deliverylog_id')
                    ->required()
                    ->numeric(),
                TextInput::make('invoice_id')
                    ->required()
                    ->numeric(),
                Toggle::make('is_loaded')
                    ->required(),
                Toggle::make('is_delivered')
                    ->required(),
                TextInput::make('logistichub_id')
                    ->required()
                    ->numeric(),
                Textarea::make('delivery_picture')
                    ->columnSpanFull(),
            ]);
    }
}
