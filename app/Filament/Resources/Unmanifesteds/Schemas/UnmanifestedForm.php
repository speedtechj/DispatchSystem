<?php

namespace App\Filament\Resources\Unmanifesteds\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UnmanifestedForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Unmanifested Details')
                ->schema([
                    MarkdownEditor::make('remarks'),
                 FileUpload::make('attachment_pic')
                ->label('Attachment')
                ->uploadingMessage('Uploading attachment...')
                ->image()
                ->disk('public')
                ->directory('unmanifested')
                ->visibility('private')
                ->required()
                ->maxSize(5120), // 5MB
                ])->columnSpanFull()

            ]);
    }
}
