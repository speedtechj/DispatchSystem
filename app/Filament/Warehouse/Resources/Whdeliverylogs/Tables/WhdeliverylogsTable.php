<?php

namespace App\Filament\Warehouse\Resources\Whdeliverylogs\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class WhdeliverylogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('trip_number')
                    ->searchable(),
                TextColumn::make('truck.plate_no')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('warehouse.name')
                    ->label('Warehouse')
                    ->sortable(),
                TextColumn::make('Total Invoices')
                    ->label('Total Invoices')
                    ->badge()
                    ->color('danger')
                    ->getStateUsing(function ($record) {
                        return $record->whtripinvoices()->count();
                    }),
                TextColumn::make('Total Load')
                    ->label('Total Load')
                    ->badge()
                    ->color('danger')
                    ->getStateUsing(function ($record) {
                        return $record->whtripinvoices()
                            ->where('is_loaded', true)
                            ->count();
                    }),
                TextColumn::make('City')
                    ->label('City')
                    ->separator(',')
                    ->color('primary')
                    ->listWithLineBreaks()
                    ->limitList(3)
                    ->expandableLimitedList()
                    ->getStateUsing(function ($record) {
                        return $record->whtripinvoices()
                            ->with('invoice')
                            ->get()
                            ->pluck('invoice.receiver_city')
                            ->filter()
                            ->unique();
                        //   ->implode(" , ");
                    }),
                TextColumn::make('Province')
                    ->label('Province')
                    ->separator(',')
                    ->color('primary')
                    ->listWithLineBreaks()
                    ->limitList(3)
                    ->expandableLimitedList()
                    ->getStateUsing(function ($record) {
                        return $record->whtripinvoices()
                            ->with('invoice')
                            ->get()
                            ->pluck('invoice.receiver_province')
                            ->filter()
                            ->unique();
                        //   ->implode(" , ");
                    }),
                TextColumn::make('departure_date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('delivery_date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('user.full_name')
                    ->numeric()
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
                    ->onColor('success')
                    ->offColor('danger')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ToggleColumn::make('is_lock')
                    ->label('Lock')
                    ->onColor('success')
                    ->offColor('danger')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                SelectFilter::make('is_lock')
                    ->label('Is Locked')
                    ->options([
                        1 => 'Yes',
                        0 => 'No',
                    ]),
                SelectFilter::make('is_active')
                    ->label('Is Active')
                    ->options([
                        1 => 'Yes',
                        0 => 'No',
                    ])->default(1),
            ])->deferFilters(false)
            ->recordActions([
                ActionGroup::make([
                    Action::make('locktrip')
                        ->requiresConfirmation()
                        ->label(function ($record) {
                            return $record->is_lock ? 'Unlock Trip' : 'Lock Trip';
                        })
                        ->color('info')
                        ->icon(function ($record) {
                            return $record->is_lock ? Heroicon::LockOpen : Heroicon::LockClosed;
                        })
                        ->hidden(function ($record) {
                            //  dd(Auth::user()->hasRole('super_admin'));
                            return Auth::user()->is_admin ? false : true;
                        })
                        ->action(function ($record) {
                            $record->update([
                                'is_lock' => !$record->is_lock,
                            ]);

                            Notification::make()
                                ->title($record->is_lock ? 'Trip Locked Successfully' : 'Trip Unlocked Successfully')
                                ->success()
                                ->send();
                        }),
                    EditAction::make()
                        ->label('Edit')
                        ->icon(Heroicon::PencilSquare)
                        ->hidden(function ($record) {
                            return $record->is_lock;
                        }),
                ])
            ], position: RecordActionsPosition::BeforeColumns)
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
