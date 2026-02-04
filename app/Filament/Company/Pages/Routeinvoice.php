<?php

namespace App\Filament\Company\Pages;

use App\Models\Invoice;
use Filament\Pages\Page;
use Filament\Tables\Table;
use App\Models\Tripinvoice;
use App\Models\Consolidator;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Tables\Grouping\Group;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Filament\Company\Resources\Deliverylogs\DeliverylogResource;

class Routeinvoice extends Page implements HasTable
{
    use InteractsWithTable;
    protected static bool $shouldRegisterNavigation = false;
    public ?int $ownerRecord = null;
    protected string $view = 'filament.company.pages.routeinvoice';
    public function mount(): void
    {
        // If visiting directly via URL
        $this->ownerRecord = request()->query('ownerRecord');
    }

        public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                Action::make('Done')
                    ->url(fn($livewire) => DeliverylogResource::getUrl('edit', ['record' => $this->ownerRecord])),

            ])
            ->defaultGroup('invdata.receiver_name')
            ->groups([
            Group::make('invdata.receiver_name')
                ->label('Receiver Name'),
            Group::make('invdata.boxtype')
                ->label('Box Type'),
            Group::make('invdata.routearea.description')
                ->label('Route Area'),
            Group::make('invdata.container.batch_no')
                ->label('Batch No'),
             Group::make('invdata.receiver_barangay')
                ->label('Barangay'),
            Group::make('invdata.receiver_city')
                ->label('City'),
            Group::make('invdata.receiver_province')
                ->label('Province'),
            ])
            ->query(
                Tripinvoice::query()
                    ->with([
                        'invoice',           // Eager load the invoice
                       // 'deliveryLogs'       // Eager load delivery logs
                    ])
                    ->where('is_loaded', true)
                    ->where('logistichub_id', Auth::user()->logistichub_id)
                    ->where('hub_assigned', false)
            )
            ->columns([
                TextColumn::make( 'company' )
                ->label('Company')
                ->getStateUsing( function($record){  
                  return Consolidator::where('code', $record->invdata->location_code)->value('company_name');
                 // return $record->invdata;
                }),
                TextColumn::make('invdata.invoice')
                    ->searchable()
                    ->label('Invoice'),
                IconColumn::make('is_returned')
                    ->boolean()
                    ->label('Returned'),
                TextColumn::make('invdata.batchno')
    ->label('Batch No')
    ->sortable(query: function (Builder $query, string $direction): Builder {
        return $query->orderBy(
            Invoice::selectRaw('CAST(batchno AS UNSIGNED)')
                ->whereColumn('invoices.id', 'tripinvoices.invoice_id'),
            $direction
        );
    }),

               
                TextColumn::make('invdata.sender_name')
                    ->label('Sender'),
                TextColumn::make('invdata.receiver_name')
                    ->label('Receiver'),
                TextColumn::make('invdata.receiver_address')
                    ->label('Address'),
                TextColumn::make('invdata.receiver_province')
                    ->sortable()
                    ->label('Province'),
                TextColumn::make('invdata.receiver_city')
                    ->label('City'),
                TextColumn::make('invdata.receiver_barangay')
                    ->label('Barangay'),
                TextColumn::make('invdata.boxtype')
                    ->label('Box Type')
                    ->summarize(Count::make()->label('Total')),
               
            ])
            ->recordActions([
                Action::make('addinvoice')
                    ->label('Add Delivery')
                    ->color('primary')
                    ->icon('heroicon-o-plus')
                    ->action(function (Model $record) {
                     
                       
                        $record->update([
                            'hub_assigned' => true,
                            'deliveryloghub_id' => $this->ownerRecord,
                            
                        ]);
                        
                        
                    })
            ])
            ->filters([
               SelectFilter::make('receiver_province')
    ->label('Province')
    ->multiple()
    ->searchable()
    ->options(
        Invoice::query()
            ->select('receiver_province')
            ->whereNotNull('receiver_province')
            ->distinct()
            ->orderBy('receiver_province')
            ->pluck('receiver_province', 'receiver_province')
    )
    ->query(function ($query, array $data) {
        if (empty($data['values'])) {
            return;
        }

        $query->whereHas('invoice', function ($q) use ($data) {
            $q->whereIn('receiver_province', $data['values']);
        });
    })
            ])->deferFilters(false)
            // ->actions([
            //     // Action::make('view')
            //     //     ->icon('heroicon-o-eye')
            //     //     ->url(fn (User $record): string => route('users.show', $record)),
                    
            //     // EditAction::make(),
            //     // DeleteAction::make(),
            // ])
            
            ->toolbarActions([
                BulkActionGroup::make([
                    //     DeleteBulkAction::make(),
                //     ExportBulkAction::make()
                // ->color('success')
                // ->icon(Heroicon::CloudArrowDown)
                // ->label('Export')
                // ->exporter(RouteinvoiceExporter::class),
                    BulkAction::make('Add Delevery Invoice')
                        ->label('Add Delivery Invoices')
                        ->color('primary')
                        ->icon(icon: Heroicon::PlusCircle)
                        ->action(function (Collection $records) {
                     //       $assignedto = Deliverylog::where('id', $this->ownerRecord)->first()->assigned_to;

                            foreach ($records as $record) {
                                 $record->update([
                            'hub_assigned' => true,
                            'deliveryloghub_id' => $this->ownerRecord,
                            
                        ]);
                                // $checkinv = Tripinvoice::where('invoice_id', $record->id)->first();
                                // if (!$checkinv) {

                                //     Tripinvoice::create([
                                //         'deliverylog_id' => $this->ownerRecord,
                                //         'logistichub_id' => $assignedto,
                                //         'invoice' => $record->invoice,
                                //         'invoice_id' => $record->id
                                //     ]);

                                //     Invoice::where('id', $record->id)->update([
                                //         'is_assigned' => 1,
                                //     ]);
                                // }
                            }

                            Notification::make()
                                ->title('Saved successfully')
                                ->success()
                                ->send();
                        })

                ])
            ])
            ->defaultSort('created_at', 'desc');
    }

}
