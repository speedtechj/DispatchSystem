<?php

namespace App\Filament\Resources\Invoiceissues\Schemas;

use App\Models\Boxissue;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InvoiceissueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('boxissue_id')
                        ->label('Box Issue')
                        ->options(function () {
                            return Boxissue::pluck('issue_type', 'id');
                        })
                        ->required()
                        ->searchable(),
                MarkdownEditor::make('remarks')
                    ->columnSpanFull(),
               FileUpload::make('attachment_pic')
                ->label('Attachment')
                ->uploadingMessage('Uploading attachment...')
                ->image()
                ->disk('public')
                ->directory('invoiceissue-attachments')
                ->visibility('private')
                ->required()
                ->maxSize(5120), // 5MB

            ]);
    }
}
