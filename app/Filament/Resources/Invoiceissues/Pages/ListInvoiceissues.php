<?php

namespace App\Filament\Resources\Invoiceissues\Pages;

use App\Filament\Resources\Invoiceissues\InvoiceissueResource;
use App\Models\Boxissue;
use App\Models\Container;
use App\Models\Invoice;
use App\Models\Invoiceissue;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ListInvoiceissues extends ListRecords
{
    protected static string $resource = InvoiceissueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->successNotification(null)
                ->label('Create Invoice Issue')
                ->slideOver()
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
                        ->live(debounce: 500)
                        ->label('Invoice Number')
                        ->required(),
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
                ])
                ->action(function (array $data): void {
                    $exists = Invoice::where('container_id', $data['container_id'])
                        ->where('invoice', $data['invoice'])
                        ->exists();
                    if ($exists) {
                        Invoiceissue::create([
                            'container_id' => $data['container_id'],
                            'invoice' => $data['invoice'],
                            'remarks' => $data['remarks'],
                            'boxissue_id' => $data['boxissue_id'],
                            'attachment_pic' => $data['attachment_pic'],
                            'user_id' => Auth::user()->id,
                        ]);

                        Notification::make()
                            ->title('Success')
                            ->body('Invoice issue created successfully.')
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Error')
                            ->body('No matching invoice found for the given container and invoice number.')
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }
}
