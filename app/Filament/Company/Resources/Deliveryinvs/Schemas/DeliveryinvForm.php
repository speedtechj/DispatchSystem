<?php

namespace App\Filament\Company\Resources\Deliveryinvs\Schemas;

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
                TextInput::make('deliveryloghub_id')
                    ->numeric(),
                Toggle::make('is_loaded_hub')
                    ->required(),
                Toggle::make('hub_assigned')
                    ->required(),
            ]);
    }
}
