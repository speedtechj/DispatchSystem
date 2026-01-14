<?php

namespace App\Filament\Company\Resources\Deliverylogs\Tables;


use Filament\Tables\Table;
use App\Models\Deliverylog;
use Filament\Actions\EditAction;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;


class DeliverylogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(Deliverylog::query()->where('logistichub_id', '=',  Auth::user()->logistichub_id))
            ->columns([
                TextColumn::make('trip_number')
                    ->searchable(),
                TextColumn::make('truck_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('trip_day')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('logistichub_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('eta')
                    ->date()
                    ->sortable(),
                TextColumn::make('departure_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('delivery_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('waybill_number')
                    ->searchable(),
                TextColumn::make('assigned_to')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_current')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('user_id')
                    ->numeric()
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
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
