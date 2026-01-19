<?php

namespace App\Filament\Pages;

use App\Models\Invoice;
use Filament\Pages\Page;
use App\Models\Container;
use Filament\Tables\Table;
use App\Models\Deliverylog;
use App\Models\Tripinvoice;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Filters\Filter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Concerns\InteractsWithTable;
use App\Filament\Resources\Deliverylogs\DeliverylogResource;


class Routeinvoice extends Page implements HasTable
{
    protected string $view = 'filament.pages.routeinvoice';
    protected static bool $shouldRegisterNavigation = false;
    use InteractsWithTable;
    public ?int $ownerRecord = null;
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
           ->query(Invoice::query()->where('is_assigned', 0))
            //->where('is_verified', 1))
            ->searchable([
            'invoice',
           // 'author.id',
            function (Builder $query, string $search): Builder {
             
                $searchdata = Invoice::where('invoice', $search)->first();
           
             if (! empty($searchdata->receiver_name)) {
    $query->where(
        'receiver_name',
        'like',
        '%' . $searchdata->receiver_name . '%'
    );
}

return $query;
           },
        ])
            ->columns([
                TextColumn::make('container.consolidator.company_name')
            //        ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Company'),
                TextColumn::make('invoice')
            //        ->searchable()
                    ->label('Invoice'),
                IconColumn::make('is_returned')
                    ->boolean()
                    ->label('Returned'),
                TextColumn::make('container.batch_no')
            //        ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Batch No'),
                TextColumn::make('container.batch_year')
            //        ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Batch Year'),
                TextColumn::make('sender_name')
                    ->label('Sender'),
                TextColumn::make('receiver_name')
                    ->label('Receiver'),
                TextColumn::make('receiver_address')
                    ->label('Address'),
                TextColumn::make('receiver_province')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Province'),
                TextColumn::make('receiver_city')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('City'),
                TextColumn::make('receiver_barangay')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Barangay'),
                TextColumn::make('boxtype')
                    ->label('Box Type'),
                TextColumn::make('routearea.description')
                    ->label('Route Area')
            ])
            ->filters([
                Filter::make('is_returned')
                    ->label('Returned')
                    ->toggle()
                    ->query(fn(Builder $query): Builder => $query->where('is_returned', true)),
                SelectFilter::make('container_id')
                    ->label('Container')
                    ->searchable()
                    ->preload()
                    ->relationship('container', 'id', fn(Builder $query) => $query->where('is_unloaded', '0'))
                    ->getOptionLabelFromRecordUsing(function (Model $record) {
                        return "{$record->container_no} {$record->batch_no} {$record->batch_year}";
                    }),
                SelectFilter::make('routearea_id')
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->label('Route Area')
                    ->relationship('routearea', 'description'),
                SelectFilter::make('receiver_province')
                    ->label('Province')
                    ->multiple()
                    ->searchable()
                    ->options(
                        Invoice::query()
                            ->select('receiver_province')
                            ->distinct()
                            ->orderBy('receiver_province')
                            ->pluck('receiver_province', 'receiver_province')
                    )
            ])->deferFilters(false)
            ->recordActions([
                Action::make('addinvoice')
                    ->label('Add Delivery')
                    ->color('primary')
                    ->icon('heroicon-o-plus')
                    ->action(function (Model $record) {
                       $assignedto = Deliverylog::where('id', $this->ownerRecord)->first();

                                    Tripinvoice::create([
                                        'deliverylog_id' => $this->ownerRecord,
                                        'logistichub_id' => $assignedto->assigned_to,
                                        'invoice' => $record->invoice,
                                        'invoice_id' => $record->id
                                    ]);
                                    Invoice::where('id', $record->id)->update([
                                        'is_assigned' => 1,
                                    ]);
                                
                            
                            })
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    //     DeleteBulkAction::make(),
                    BulkAction::make('Add Delevery Invoice')
                        ->action(function (Collection $records) {
                            $assignedto = Deliverylog::where('id', $this->ownerRecord)->first()->assigned_to;

                            foreach ($records as $record) {
                                $checkinv = Tripinvoice::where('invoice_id', $record->id)->first();
                                if (!$checkinv) {

                                    Tripinvoice::create([
                                        'deliverylog_id' => $this->ownerRecord,
                                        'logistichub_id' => $assignedto,
                                        'invoice' => $record->invoice,
                                        'invoice_id' => $record->id
                                    ]);

                                    Invoice::where('id', $record->id)->update([
                                        'is_assigned' => 1,
                                    ]);
                                }
                            }

                            Notification::make()
                                ->title('Saved successfully')
                                ->success()
                                ->send();
                        })

                ])
            ]);
    }
}
