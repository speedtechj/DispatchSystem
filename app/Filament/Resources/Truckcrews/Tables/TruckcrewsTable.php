<?php

namespace App\Filament\Resources\Truckcrews\Tables;

use App\Models\User;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class TruckcrewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('truck.plate_no')
                    ->sortable(),
                TextColumn::make('driver')
                    ->label('Driver')
                    ->sortable()
                    ->getStateUsing(function (Model $record) {
                        
                        $drivername = User::where('id',$record->driver)->first()->full_name;
                        return $drivername;
                        // return $record->driver ? $record->user->full_name : 'Driver not assigned';
                    }),
                TextColumn::make('leadman')
                   ->getStateUsing(function (Model $record) {
                        $leadman = User::where('id',$record->leadman)->first()->full_name;
                        return $leadman;
                    })
                    ->sortable(),
                TextColumn::make('Porter')
                    ->getStateUsing(function (Model $record) {
                        
                        $porter = User::where('id',$record->Porter)->first()->full_name;
                        return $porter;
                    })
                    ->sortable(),
                 TextColumn::make('user.full_name')
                    ->label('Created By')
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
