<?php

namespace App\Filament\Company\Resources\Trucks\Tables;

use App\Models\Truck;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class TrucksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(Truck::query()->where('logistichub_id', '=',  Auth::user()->logistichub_id))
            ->columns([
                TextColumn::make('category')
                    ->searchable(),
                TextColumn::make('description')
                    ->searchable(),
                TextColumn::make('registration_no')
                    ->searchable(),
                TextColumn::make('plate_no')
                    ->searchable(),
                TextColumn::make('user.full_name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('date_registered')
                    ->date()
                    ->sortable(),
                TextColumn::make('date_expired')
                    ->date()
                    ->sortable(),
                // TextColumn::make('logistichub_id')
                //     ->numeric()
                //     ->sortable(),
                IconColumn::make('is_assigned')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->boolean(),
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
