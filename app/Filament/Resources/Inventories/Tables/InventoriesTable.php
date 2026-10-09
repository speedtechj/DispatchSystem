<?php

namespace App\Filament\Resources\Inventories\Tables;

use App\Filament\Resources\Deliverylogs\DeliverylogResource;
use App\Models\Inventory;
use App\Models\Invoice;
use App\Models\Tripinvoice;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;


class InventoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(
                Inventory::byReceiverProvince()->where('is_verified', 1)
            )
            ->columns([
                TextColumn::make('tripno')
                    ->label('Trip Number')
                    ->getStateUsing(function ($record) {
                        $tripinvoice = Tripinvoice::where('invoice_id', $record->id)->first();
                        return $tripinvoice->deliverylog->trip_number ?? 'Not Assigned';
                    })
                    ->url(function ($record) {
                        $tripinvoice = Tripinvoice::where('invoice_id', $record->id)->first();
                        if ($tripinvoice !== null) {
                            return DeliverylogResource::getUrl('edit', ['record' => $tripinvoice->deliverylog->id]) ?? 'not assigned';
                        }
                    })
                    ->color('primary'),
                TextColumn::make('invoice')
                    ->label('Invoice')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('sender_name')
                    ->label('Sender Name')
                    ->sortable(),
                TextColumn::make('receiver_name')
                    ->label('Receiver Name')
                    ->sortable(),
                TextColumn::make('receiver_address')
                    ->label('Receiver Address')
                    ->sortable(),
                TextColumn::make('receiver_barangay')
                    ->label('Receiver Barangay')
                    ->sortable(),
                TextColumn::make('receiver_city')
                    ->label('Receiver City')
                    ->sortable(),
                TextColumn::make('receiver_province')
                    ->label('Receiver Province')
                    ->sortable(),
                TextColumn::make('container.container_no')
                    ->label('Container No')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('warehouse.name')
                    ->label('Warehouse')
                    ->sortable(),
                IconColumn::make('tripInvoices.is_loaded')
                    ->label('Loaded')
                    ->boolean()
                    ->getStateUsing(
                        fn($record): bool =>
                        $record->tripInvoices()->where('is_loaded', 1)->exists()
                    )
                    ->trueColor('success')
                    ->falseColor('danger')
            ])
            ->filters([
                SelectFilter::make('receiver_province')
                    ->label('Receiver Province')
                    ->options(
                        fn() => Inventory::query()
                            ->whereNotNull('receiver_province')
                            ->where('receiver_province', '!=', '')
                            ->distinct()
                            ->orderBy('receiver_province')
                            ->pluck('receiver_province', 'receiver_province')
                            ->toArray()
                    )
                    ->searchable()
                    ->multiple(), // remove if you only want one province at a time
            ])->deferFilters(false)
            ->recordActions([
                //  EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('Mark as Loaded')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $tripInvoice = Tripinvoice::where('invoice_id', $record->id)->first();
                                if ($tripInvoice) {
                                    $tripInvoice->is_loaded = true;
                                    $tripInvoice->save();
                                }
                            }
                        })
                        ->requiresConfirmation()
                        ->color('success')
                        ->icon('heroicon-o-truck'),

                ]),
            ]);
    }
}
