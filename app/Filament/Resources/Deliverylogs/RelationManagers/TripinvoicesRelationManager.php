<?php

namespace App\Filament\Resources\Deliverylogs\RelationManagers;

use App\Models\Invoice;
use Filament\Tables\Table;
use App\Models\Tripinvoice;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Actions\BulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ActionGroup;
use Filament\Support\Enums\Width;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ExportAction;
use App\Filament\Pages\Scaninvoice;
use App\Filament\Pages\Routeinvoice;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\DissociateBulkAction;
use App\Filament\Exports\TripinvoiceExporter;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Resources\Routeinvoices\RouteinvoiceResource;

class TripinvoicesRelationManager extends RelationManager
{
    protected static string $relationship = 'tripinvoices';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('trip_number')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('deliverylog.trip_number')
                    ->label('Trip Number')
                    ->searchable(),
                TextColumn::make('invoice.invoice')
                    ->label('Invoice No'),
                // TextColumn::make('invoice.sender_name')
                // ->label('Sender'),
                TextColumn::make('invoice.receiver_name')
                    ->label('Receiver'),
                TextColumn::make('invoice.receiver_address')
                    ->label('Address'),
                TextColumn::make('invoice.receiver_province')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Province'),
                TextColumn::make('invoice.receiver_city')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('City'),
                TextColumn::make('invoice.receiver_barangay')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Barangay'),
                TextColumn::make('invoice.boxtype')
                    ->label('Box Type'),
                TextColumn::make('invoice.routearea.description')
                    ->label('Route Area')

            ])
            ->filters([])
            ->headerActions([
                Action::make('Assign Invoice')
                    ->url(fn($livewire) => Routeinvoice::getUrl(['ownerRecord' => $livewire->ownerRecord->getKey()])),
                ExportAction::make()
                    ->label('Export')
                    ->exporter(TripinvoiceExporter::class)
                    ->color('info')
                    ->icon('heroicon-o-arrow-down-tray'),
            ])
            ->recordActions([
                ActionGroup::make([
                    // Print Function
                    Action::make('Print')
                        ->label('Print')
                        ->color('primary')
                        ->icon('heroicon-o-printer')
                        ->url(fn (Model $record) => route('invoicepdf', $record->invoice_id))
                ->openUrlInNewTab(),
                    // Export Function

                    // Action::make('Export')
                    // ->label('Export')
                    //  ->requiresConfirmation()

                    // Delete function
                    Action::make('Delete')
                        ->before(function ($record) {

                            $record->invoice()->update([
                                'is_assigned' => 0
                            ]);
                        })
                        ->after(function ($record) {
                            $record->delete();
                        })
                        ->requiresConfirmation()
                        ->color('danger')
                        ->icon('heroicon-o-trash'),

                ])

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('delete')
                        ->label('Remove Selected')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                Invoice::find($record->invoice_id)?->update([
                                    'is_assigned' => 0,
                                ]);
                                $record->delete();
                            }
                        })
                        ->requiresConfirmation()
                        ->color('danger')
                        ->icon('heroicon-o-trash')

                ]),
            ]);
    }
}
