<?php

namespace App\Filament\Warehouse\Resources\Containers\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ContainerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('consolidator_id')
                    ->numeric(),
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('container_no'),
                TextEntry::make('booking_no'),
                TextEntry::make('batch_no')
                    ->placeholder('-'),
                TextEntry::make('batch_year')
                    ->placeholder('-'),
                IconEntry::make('is_unloaded')
                    ->boolean(),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('seal_number'),
                TextEntry::make('size'),
                TextEntry::make('type'),
                TextEntry::make('total_boxes')
                    ->numeric(),
                TextEntry::make('note')
                    ->placeholder('-'),
                TextEntry::make('container_picture')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('warehouse_id')
                    ->numeric()
                    ->placeholder('-'),
            ]);
    }
}
