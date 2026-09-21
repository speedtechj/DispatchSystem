<?php

namespace App\Filament\Resources\Inventories\Tables;

use App\Filament\Resources\Deliverylogs\DeliverylogResource;
use App\Models\Inventory;
use App\Models\Invoice;
use App\Models\Tripinvoice;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Table;


class InventoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(
                Inventory::byReceiverProvince()->where('is_verified',1)
            )
            ->columns([
                   TextColumn::make( 'tripno' )
            ->label('Trip Number')
          ->getStateUsing(function($record){
               $tripinvoice = Tripinvoice::where('invoice_id',$record->id)->first();
               return $tripinvoice->deliverylog->trip_number ?? 'Not Assigned';
           })
            ->url(function($record){
                $tripinvoice = Tripinvoice::where('invoice_id',$record->id)->first();
                if($tripinvoice !== null){
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
                //
            ])
            ->recordActions([
                //  EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //       DeleteBulkAction::make(),
                ]),
            ]);
    }
}
