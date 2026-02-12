<?php

namespace App\Filament\Resources\Deliveryinvs\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class DeliveryinvInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ImageEntry::make('delivery_picture')
                    ->label('Delivery Picture')
                     ->imageWidth(500)
                     ->imageHeight(500)
                    ->disk('public')
                    ->stacked()
    ->limit(3)
                    ->visibility('public'),

            ])->columns('2');
    }
}
