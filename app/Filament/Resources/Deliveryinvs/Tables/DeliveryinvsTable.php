<?php

namespace App\Filament\Resources\Deliveryinvs\Tables;

use App\Models\Consolidator;
use App\Models\Invoice;
use App\Models\Container;
use App\Models\Routearea;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Filters\SelectFilter;

class DeliveryinvsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice')
                    ->searchable()
                    ->label('Invoice'),
                TextColumn::make('invoice.sender_name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Sender'),
                TextColumn::make('invoice.receiver_name')
                    ->label('Receiver'),
                TextColumn::make('invoice.receiver_address')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Address'),
                TextColumn::make('is_delivered')
                    ->label('Status')
                    ->formatStateUsing(function (Model $record) {
                        return $record->is_delivered ? 'Delivered' : 'In Transit';
                    })
                    ->color(function ($record) {
                        return $record->is_delivered ? 'success' : 'danger';
                    }),
                TextColumn::make('company')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Company')
                    ->getStateUsing(function (Model $record) {
                        // $companyname = Consolidator::where('code', $records->location_code)->first();
                        $locationcode = Invoice::where('id', $record->invoice_id)->value('location_code');
                        return  $companyname = Consolidator::where('code', $locationcode)->value('company_name');
                    }),
                TextColumn::make('invoice.receiver_province')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Province'),
                TextColumn::make('invoice.receiver_city')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('City'),
                TextColumn::make('invoice.receiver_barangay')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Barangay'),
                TextColumn::make('invoice.boxtype')
                    ->label('Box Type'),
                TextColumn::make('invoice.routearea.description')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Route Area')
            ])
            ->filters([
                SelectFilter::make('routearea_id')
                    ->label('Route')
                    ->relationship('invoice.routearea', 'description'),
                SelectFilter::make('deliverylog_id')
                    ->label('Trip Number')
                    ->relationship('deliverylog', 'trip_number')

            ])->deferFilters(false)
            ->recordActions([
                //     EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
