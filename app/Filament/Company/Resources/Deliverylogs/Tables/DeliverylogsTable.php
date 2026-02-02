<?php

namespace App\Filament\Company\Resources\Deliverylogs\Tables;

use Filament\Tables\Table;
use App\Models\Deliverylog;
use App\Models\Tripinvoice;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use App\Filament\Exports\TripinvoiceExporter;


class DeliverylogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(Deliverylog::query()->where('logistichub_id', '=',  Auth::user()->logistichub_id))
            ->columns([
                TextColumn::make('trip_number')
                    ->searchable(),
                TextColumn::make('truck.plate_no')
                    ->sortable(),
                TextColumn::make('trip_day')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('Total Invoices')
                    ->badge()
                    ->color('success')
                    ->label('Total Invoices')
                    ->getStateUsing(function ($record) {
 
                        return Tripinvoice::where('deliveryloghub_id', $record->id)->count();
                    }),
                TextColumn::make('Total Loaded')
                    ->badge()
                    ->color('success')
                    ->label('Total Loaded')
                    ->getStateUsing(function ($record) {
 
                        return Tripinvoice::where('deliveryloghub_id', $record->id)->where('is_loaded_hub', 1)->count();
                    }),
                TextColumn::make('eta')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->date()
                    ->sortable(),
                TextColumn::make('departure_date')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->date()
                    ->sortable(),
                TextColumn::make('delivery_date')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->date()
                    ->sortable(),
                TextColumn::make('waybill_number')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('user.full_name')
                    ->label('Created By')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('releasetruct')
                    ->requiresConfirmation()
                    ->label('Released Truck')
                    ->color('info')
                    ->icon(Heroicon::Truck)
                    ->hidden(function ($record) {
   
                        return !$record->is_current;
                    })
                    ->action(function ($record) {

                        $record->truck->update([
                            'is_assigned' => 0,
                        ]);
                        $record->update([
                            'is_current' => 0,
                            'is_active' => 0,
                        ]);

                        Notification::make()
                            ->title('Truck Released Successfully')
                            ->success()
                            ->send();
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
