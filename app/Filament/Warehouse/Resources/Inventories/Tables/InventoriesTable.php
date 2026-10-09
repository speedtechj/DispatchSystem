<?php

namespace App\Filament\Warehouse\Resources\Inventories\Tables;

use App\Filament\Warehouse\Resources\Deliverylogs\DeliverylogResource;
use App\Models\Inventory;
use App\Models\Tripinvoice;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class InventoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(
                Inventory::byReceiverProvince()
                    ->where('is_verified', 1)
                    ->where('warehouse_id', Auth::user()->warehouse_id)
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
                    ->searchable(),
                TextColumn::make('batchno')
                    ->searchable(),
                TextColumn::make('sender_name')
                    ->searchable(),
                TextColumn::make('receiver_name')
                    ->searchable(),
                TextColumn::make('receiver_address')
                    ->searchable(),
                TextColumn::make('receiver_province')
                    ->searchable(),
                TextColumn::make('receiver_city')
                    ->searchable(),
                TextColumn::make('receiver_barangay')
                    ->searchable(),
                TextColumn::make('boxtype')
                    ->searchable(),
                TextColumn::make('warehouse.name')
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
