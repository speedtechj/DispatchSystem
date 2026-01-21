<?php

namespace App\Filament\Resources\Deliverylogs\Tables;

use Filament\Tables\Table;
use App\Models\Deliverylog;
use App\Models\Logistichub;
use App\Models\Tripinvoice;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ToggleColumn;
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
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('logistichub.hub_name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Logistic Hub/Location'),
                TextColumn::make('Total Invoices')
                    ->label('Total Invoices')
                    ->badge()
                    ->color('danger')
                    ->getStateUsing(function ($record) {
                        return $record->tripinvoices()->count();
                    }),
                TextColumn::make('Total Loaded')
                    ->badge()
                    ->color('success')
                    ->label('Total Loaded')
                    ->getStateUsing(function ($record) {
                        return $record->tripinvoices()->whereHas('invoice', function ($query) {
                            $query->where('is_loaded', 1);
                        })->count();
                    }),
                TextColumn::make('Verified Invoices')
                    ->label('Invoices Verified')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color('info')
                    ->getStateUsing(function ($record) {
                        return $record->tripinvoices()->whereHas('invoice', function ($query) {
                            $query->where('is_verified', 1);
                        })->count();
                        // return $record->tripinvoices->invoices->where('is_verified', 1)->count();
                    }),
                TextColumn::make('eta')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('ETA')
                    ->date()
                    ->sortable(),
                TextColumn::make('departure_date')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->date()
                    ->sortable(),
                TextColumn::make('assigned_to')
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        // return $record->assigned_to;

                        return Logistichub::where('id', $record->assigned_to)->first()->hub_name;
                        // return $record->logistichub->hub_name;
                        // return $record->truck ? $record->truck->plate_no : 'Truck not assigned';
                    }),
                TextColumn::make('user.full_name')
                    ->label('Created By')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),

                ToggleColumn::make('is_active')
                    ->label('Is Active')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                SelectFilter::make('is_active')
                    ->label('Is Active')
                    ->options([
                        1 => 'Yes',
                        0 => 'No',
                    ])->default(0),
                SelectFilter::make('assigned_to')
                    ->label('Going To')
                    ->options(Logistichub::query()->pluck('hub_name', 'id'))
                    ->searchable()
                    ->preload(),
            ])->deferFilters(false)
            ->recordActions([
                Action::make('releasetruct')
                    ->requiresConfirmation()
                    ->label('Released Truck')
                    ->color('info')
                    ->icon(Heroicon::Truck)
                    ->action(function ($record) {

                        $record->truck->update([
                            'is_assigned' => 0,
                        ]);
                        $record->update([
                            'is_current' => 0,
                        ]);

                        Notification::make()
                            ->title('Truck Released Successfully')
                            ->success()
                            ->send();
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //   DeleteBulkAction::make(),
                ]),
            ]);
    }
}
