<?php

namespace App\Filament\Resources\Inventories\Tables;

use App\Models\Inventory;
use App\Models\Invoice;
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
                Inventory::byReceiverProvince()
            )
            ->columns([
                TextColumn::make('invoice')
                    ->label('Invoice')
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
