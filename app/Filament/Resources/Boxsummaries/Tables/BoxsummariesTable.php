<?php

namespace App\Filament\Resources\Boxsummaries\Tables;

use App\Models\Invoice;
use Filament\Tables\Table;
use App\Models\Consolidator;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\Summarizers\Count;

class BoxsummariesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultGroup('receiver_name')
            ->groups([
            'receiver_name',
            'receiver_barangay',
            'receiver_city',
            'receiver_province',
            'boxtype',
            'routearea.description',
            'container.batch_no',
        ])
            ->columns([
               TextColumn::make( 'company' )
                ->label('Company')
                ->getStateUsing( function($record){  
                    return Consolidator::where('code', $record->location_code)->value('company_name');
                }),
                TextColumn::make('invoice')
                    ->label('Invoice'),
                TextColumn::make('batchno')
                    ->label('Batch No')
             //       ->sortable(),
                    ->sortable(query: function (Builder $query, string $direction): Builder {
        return $query->orderByRaw('CAST(batchno AS UNSIGNED) ' . $direction);
    }),
                TextColumn::make('container.batch_year')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Batch Year'),
                TextColumn::make('sender_name')
                    ->label('Sender'),
                TextColumn::make('receiver_name')
                    ->label('Receiver'),
                TextColumn::make('receiver_address')
                    ->label('Address'),
                TextColumn::make('receiver_province')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Province'),
                TextColumn::make('receiver_city')
                    ->toggleable(isToggledHiddenByDefault: true)
                     ->label('City/Municipality'),
                TextColumn::make('receiver_barangay')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Barangay'),
                TextColumn::make('boxtype')
                    ->label('Box Type')
                    ->summarize(Count::make()->label('Total')),
                TextColumn::make('routearea.description')
                    ->label('Route Area')
            ])
            ->filters([
                 SelectFilter::make('container_id')
                    ->label('Container')
                    ->searchable()
                    ->preload()
                    ->relationship('container', 'id', fn(Builder $query) => $query->where('is_unloaded', '1'))
                    ->getOptionLabelFromRecordUsing(function (Model $record) {
                        return "{$record->container_no} {$record->batch_no} {$record->batch_year}";
                    }),
                SelectFilter::make('receiver_province')
                    ->label('Province')
                    ->multiple()
                    ->searchable()
                    ->options(
                        Invoice::query()
                            ->select('receiver_province')
                            ->distinct()
                            ->orderBy('receiver_province')
                            ->pluck('receiver_province', 'receiver_province')
                    ),
                    SelectFilter::make('location_code')
                    ->label('Company')
                    ->multiple()
                    ->searchable()
                   ->options(
                        Consolidator::query()
                            ->select('code', 'company_name')
                            ->orderBy('company_name')
                            ->pluck('company_name', 'code')
                    ),
            ])->deferFilters(false)
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
