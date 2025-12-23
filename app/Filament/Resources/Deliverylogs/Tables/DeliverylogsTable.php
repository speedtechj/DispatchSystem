<?php

namespace App\Filament\Resources\Deliverylogs\Tables;

use Filament\Tables\Table;
use App\Models\Logistichub;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
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
                TextColumn::make('Total Invoices')
                    ->label('Total Invoices')
                    ->badge()
                     ->color('danger')
                    ->getStateUsing(function ($record) {
                        return $record->tripinvoices()->count();
                    }),
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
                    ->label('Logistic Hub/Location'),
                 TextColumn::make('Total Loaded')
                    ->badge()
                    ->color('success')
                    ->label('Total Loaded')
                    ->getStateUsing(function ($record) {
                        return $record->tripinvoices()->whereHas('invoice', function ($query) {
                            $query->where('is_loaded', 1);
                        })->count();
                    }),
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
