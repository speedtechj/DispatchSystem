<?php

namespace App\Filament\Resources\Unmanifesteds\Schemas;

use Filament\Schemas\Schema;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class UnmanifestedInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // TextEntry::make('invoice')
                //     ->placeholder('-'),
                // TextEntry::make('container_id')
                //     ->numeric(),
                TextEntry::make('remarks')
                    ->placeholder('-'),
                  
                ImageEntry::make('attachment_pic')
                     ->visibility('public')
                    ->disk('public'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
