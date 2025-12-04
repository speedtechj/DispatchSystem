<?php

namespace App\Filament\Resources\Deliverylogs\Tables;

use Filament\Tables\Table;
use App\Models\Logistichub;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class DeliverylogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('trip_number')
                    ->searchable(),
                TextColumn::make('truck_id')
                    ->label('Truck')
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        return $record->truck ? $record->truck->plate_no : 'Truck not assigned';
                    }),   
                TextColumn::make('trip_day')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('logistichub.hub_name')
                    ->label('Logistic Hub/Location')
                    ->searchable(),
                TextColumn::make('eta')
                    ->label('ETA')
                    ->date()
                    ->sortable(),
                TextColumn::make('departure_date')
                    ->date()
                    ->sortable(),
                  TextColumn::make('assigned_to')
                    ->sortable()
                     ->getStateUsing(function ($record) {
                       // return $record->assigned_to;

                    return Logistichub::where('id',$record->assigned_to)->first()->hub_name;
                       // return $record->logistichub->hub_name;
                       // return $record->truck ? $record->truck->plate_no : 'Truck not assigned';
                    }), 
                TextColumn::make('user.full_name')
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
               SelectFilter::make('logistichub_id')
                    ->label('Logistic Hub')
                    ->options(Logistichub::query()->pluck('hub_name', 'id'))
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                 //   DeleteBulkAction::make(),
                ]),
            ]);
    }
}
