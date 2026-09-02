<?php

namespace App\Filament\Warehouse\Resources\Containers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ContainersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                 TextColumn::make('consolidator.company_name')
                    ->sortable(),
                TextColumn::make('container_no')
                    ->searchable(),
                TextColumn::make('warehouse.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('booking_no')
                     ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                 TextColumn::make('batch_no')
                    ->searchable(),
                TextColumn::make('batch_year')
                     ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('seal_number')
                     ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('size')
                     ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('type')
                     ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('total_boxes')
                    ->numeric()
                    ->sortable(),
                  TextColumn::make('Total Imported')
                    ->badge()
                    ->color('info')
                    ->numeric()
                    ->getStateUsing(function ($record) {
                        return $record->invoices()->count();
                    }),
                  TextColumn::make('Total Unloaded')
                    ->badge()
                    ->color('success')
                    ->numeric()
                    ->getStateUsing(function ($record) {
                        return $record->invoices()->where('is_verified', 1)->count();
                    }),
                TextColumn::make('note')
                     ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                ToggleColumn::make('is_unloaded')
                    ->label('Is Unloaded')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                 TextColumn::make('user.full_name')
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
                 ToggleColumn::make('is_active')
                    ->label('Active')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('is_unloaded')
                    ->label('Is Unloaded')
                    ->options([
                        1 => 'Yes',
                        0 => 'No',
                    ])->default(0),
                SelectFilter::make('consolidator_id')
                    ->label('Consolidator')
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->relationship('consolidator', 'company_name'),
            ])->deferFilters(false)
            ->recordActions([
           //     ViewAction::make(),
            //    EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
          //          DeleteBulkAction::make(),
                ]),
            ]);
    }
}
