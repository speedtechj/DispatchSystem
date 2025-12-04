<?php

namespace App\Filament\Resources\Invoiceissues\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class InvoiceissueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('invoice'),
                TextInput::make('container_id')
                    ->required()
                    ->numeric(),
                Textarea::make('remarks')
                    ->columnSpanFull(),
                Textarea::make('attachment_pic')
                    ->columnSpanFull(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('boxissue_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
