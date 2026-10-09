<?php

namespace App\Filament\Warehouse\Resources\Inventories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class InventoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('container_id')
                    ->required()
                    ->numeric(),
                TextInput::make('invoice')
                    ->required(),
                TextInput::make('batchno'),
                TextInput::make('sender_name')
                    ->required(),
                TextInput::make('receiver_name')
                    ->required(),
                TextInput::make('receiver_address')
                    ->required(),
                TextInput::make('receiver_province')
                    ->required(),
                TextInput::make('receiver_city')
                    ->required(),
                TextInput::make('receiver_barangay')
                    ->required(),
                TextInput::make('receiver_mobile_no')
                    ->required(),
                TextInput::make('receiver_home_no'),
                TextInput::make('boxtype')
                    ->required(),
                TextInput::make('routearea_id')
                    ->numeric(),
                Toggle::make('is_verified')
                    ->required(),
                Toggle::make('is_returned')
                    ->required(),
                Toggle::make('is_delivered')
                    ->required(),
                Toggle::make('is_assigned')
                    ->required(),
                TextInput::make('user_id')
                    ->numeric(),
                TextInput::make('location_code')
                    ->required(),
                Toggle::make('is_priority')
                    ->required(),
                TextInput::make('problem_description'),
                Toggle::make('is_resolved')
                    ->required(),
                Textarea::make('remark')
                    ->columnSpanFull(),
                TextInput::make('warehouse_id')
                    ->numeric(),
                Toggle::make('wh_is_assigned')
                    ->required(),
            ]);
    }
}
