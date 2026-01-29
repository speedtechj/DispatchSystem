<?php

namespace App\Filament\Company\Resources\Deliverylogs\RelationManagers;

use App\Models\Invoice;
use Filament\Tables\Table;
use App\Models\Deliverylog;
use App\Models\Tripinvoice;
use App\Models\Consolidator;
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
use Filament\Tables\Filters\Filter;
use App\Filament\Pages\Routeinvoice;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\DissociateBulkAction;
use App\Filament\Company\Pages\Routinvoice;
use App\Filament\Exports\TripinvoiceExporter;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Resources\RelationManagers\RelationManager;
use App\Filament\Company\Pages\Routeinvoice as PagesRouteinvoice;

class TripinvoicesRelationManager extends RelationManager
{
    protected static string $relationship = 'tripinvoices';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('invoice')
                    ->required()
                    ->maxLength(255),
            ]);
    }

     public function table(Table $table): Table
    {
        return $table
         //  ->poll('5s')
            ->recordTitleAttribute('id')
            ->query(Tripinvoice::query()->where('deliveryloghub_id', $this->ownerRecord->id))
            ->columns([
                TextColumn::make('invoice.consolidator.company_name')
    ->label('Company')
    ->sortable(query: function ($query, $direction) {
        $query
            ->join(
                'invoices',
                'invoices.id',
                '=',
                'tripinvoices.invoice_id'
            )
            ->join(
                'consolidators',
                'consolidators.code',
                '=',
                'invoices.location_code'
            )
            ->orderBy('consolidators.company_name', $direction)
            ->select('tripinvoices.*');
    }),
                TextColumn::make('deliveryloghub_id')
                    ->label('Trip Number')
                    ->getStateUsing( function($record){  
                        return Deliverylog::find($record->deliveryloghub_id)->trip_number;
                    })
                    ->searchable(),
                TextColumn::make('invoice.invoice')
                    ->sortable()
                    ->searchable(isIndividual: true)
                    ->label('Invoice No'),
                TextColumn::make('invoice.container.batch_no')
                    ->label('Batch No')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('invoice.container.batch_year')
                    ->label('Batch Year')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('invoice.receiver_name')
                    ->label('Receiver'),
                TextColumn::make('invoice.receiver_address')
                    ->label('Address'),
                TextColumn::make('invoice.receiver_province')
                    ->sortable()
                    ->label('Province'),
                TextColumn::make('invoice.receiver_city')
                    ->label('City'),
                TextColumn::make('invoice.receiver_barangay')
                    ->label('Barangay'),
                TextColumn::make('invoice.boxtype')
                    ->label('Box Type'),
                TextColumn::make('invoice.routearea.description')
                    ->label('Route Area'),
                IconColumn::make('is_loaded_hub')
                    ->label('Loaded')
                    ->color(fn(bool $state) => $state ? 'success' : 'danger')
                    ->icon(fn(bool $state) => match ($state) {
                        true => 'heroicon-o-check-circle',
                        false => 'heroicon-o-x-circle',
                    })

            ])
            ->filters([

                Filter::make('is_loaded')
                    ->label('Not Loaded')
                    ->toggle()
                    ->query(fn(Builder $query): Builder => $query->where('is_loaded', false)),


            ])->deferFilters(false)
            ->headerActions([
                Action::make('Assign Invoice')
                    ->url(fn($livewire) => Routeinvoice::getUrl(['ownerRecord' => $livewire->ownerRecord->getKey()])),
                ExportAction::make()
                    ->label('Export')
                    ->exporter(TripinvoiceExporter::class)
                    ->color('info')
                    ->icon('heroicon-o-arrow-down-tray')
            ])
            ->recordActions([
                ActionGroup::make([
                    // Print Function
                    Action::make('Print')
                        ->label('Print')
                        ->color('primary')
                        ->icon('heroicon-o-printer')
                        ->url(fn(Model $record) => route('invoicepdf', $record->invoice_id))
                        ->openUrlInNewTab(),
                    // Export Function

                    // Action::make('Export')
                    // ->label('Export')
                    //  ->requiresConfirmation()

                    // Delete function
                    Action::make('Delete')
                        ->before(function ($record) {
                  //  dd($record);
                            $record->update([
                                    'hub_assigned' => 0,
                                    'deliveryloghub_id' => null,
                                    'is_loaded_hub' => 0,
                            ]);
                        })
                        ->requiresConfirmation()
                        ->color('danger')
                        ->icon('heroicon-o-trash'),

                ])

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('delete')
                        ->label('Remove ')
                        ->action(function ($records) {

                           // dump($records);
                            foreach ($records as $record) {
                                Tripinvoice::find($record->id)?->update([
                                    'hub_assigned' => 0,
                                    'deliveryloghub_id' => null,
                                    'is_loaded_hub' => 0,
                                ]);
                               
                             }
                            Notification::make()
                                ->title('Invoice removed successfully')
                                ->success()
                                ->send();
                        })
                        ->requiresConfirmation()
                        ->color('danger')
                        ->icon('heroicon-o-trash'),
                    BulkAction::make('Return')
                        ->label('Return')
                        ->icon(Heroicon::Backward)
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                Invoice::find($record->invoice_id)?->update([
                                    'is_returned' => 1,
                                    'is_assigned' => 0,
                                ]);
                                $record->delete();
                            }
                            Notification::make()
                                ->title('Invoice returned successfully')
                                ->success()
                                ->send();
                        })
                        ->requiresConfirmation()
                        ->color('warning'),
                    BulkAction::make('Loaded')
                        ->color('success')
                        ->label('Mark as Loaded')
                        ->icon(Heroicon::Truck)
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update([
                                    'is_loaded' => 1,
                                ]);
                            }
                            Notification::make()
                                ->title('Invoice Loaded successfully')
                                ->success()
                                ->send();

                            $tripcount = Tripinvoice::where('deliverylog_id', $record->deliverylog_id)->count();
                            $totalloaded = Tripinvoice::where('deliverylog_id', $record->deliverylog_id)->where('is_loaded', true)->count();
                            if ($totalloaded > 0) {
                                if ($tripcount == $totalloaded) {
                                    $Deliverydata = Deliverylog::find($record->deliverylog_id);
                                    $Deliverydata->truck->update([
                                        'is_assigned' => true,
                                    ]);
                                    $Deliverydata->update([
                                        'is_current' => true,

                                    ]);
                                }
                            }
                        })

                ]),
            ]);
    }
}
