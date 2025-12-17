<?php

namespace App\Filament\Resources\Invoiceissues\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;

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
                MarkdownEditor::make('remarks')
                    ->columnSpanFull(),
               FileUpload::make('attachment_pic')
                ->label('Attachment')
                ->uploadingMessage('Uploading attachment...')
                ->image()
                ->disk('public')
                ->directory('unmanifested')
                ->visibility('private')
                ->required()
                ->maxSize(5120), // 5MB
                
            ]);
    }
}
