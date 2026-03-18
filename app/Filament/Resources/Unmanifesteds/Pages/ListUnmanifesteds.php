<?php

namespace App\Filament\Resources\Unmanifesteds\Pages;

use App\Filament\Resources\Unmanifesteds\UnmanifestedResource;
use App\Models\Container;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Section;

class ListUnmanifesteds extends ListRecords
{
    protected static string $resource = UnmanifestedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->slideOver()
            ->successNotification(null)
            ->label('Create Unmanifested')
            ->schema([

                Section::make('Unmanifested Details')
                ->schema([
                Select::make('container_id')
                        ->label('Container')
                        ->options(function () {
                            return Container::where('is_active', true)
                                ->pluck('container_no', 'id');
                        })
                        ->searchable()
                        ->required(),
                TextInput::make('invoice')
                ->label('Invoice Number')
                ->numeric()
                ->required(),
                MarkdownEditor::make('remarks')
                ->label('Remarks'),
                FileUpload::make('attachment_pic')
                ->label('Attachment')
                ->uploadingMessage('Uploading attachment...')
                ->image()
                ->disk('public')
                ->directory('unmanifested')
                ->visibility('private')
                ->required()
                ->maxSize(5120), // 5MB

                ])
            ]),
        ];
    }
}
