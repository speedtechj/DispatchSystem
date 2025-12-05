<?php

namespace App\Filament\Pages;

use App\Filament\Resources\Deliverylogs\DeliverylogResource;
use App\Models\Invoice;
use Filament\Pages\Page;
use Filament\Tables\Table;
use App\Models\Deliverylog;
use App\Models\Tripinvoice;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Concerns\InteractsWithTable;


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
            ->columns([
                TextColumn::make('invoice')
                ->label('Invoice'),
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
                SelectFilter::make('routearea_id')
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->label('Route Area')
                    ->relationship('routearea', 'description')
            ])->deferFilters(false)
            ->recordActions([
                

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
