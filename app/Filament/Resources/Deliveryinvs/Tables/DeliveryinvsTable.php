<?php

namespace App\Filament\Resources\Deliveryinvs\Tables;

use App\Filament\Resources\Deliverylogs\DeliverylogResource;
use App\Models\Consolidator;
use App\Models\Container;
use App\Models\Deliveryinv;
use App\Models\Invoice;
use App\Models\Routearea;
use App\Models\Tripinvoice;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\ImageEntry;
use Filament\Support\Enums\Size;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DeliveryinvsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(Deliveryinv::Unloadedinv())
            ->columns([
                TextColumn::make('deliverylog.trip_number')
                    ->searchable()
                    ->label('Trip Number')
                    ->color('primary')
                    ->url(fn(Model $record) => DeliverylogResource::getUrl('edit', ['record' => $record->deliverylog_id])),
               TextColumn::make('company')
                    ->label('Company')
                    ->getStateUsing(function (Model $record) {
                        // $companyname = Consolidator::where('code', $records->location_code)->first();
                        $locationcode = Invoice::where('id', $record->invoice_id)->value('location_code');
                        return  $companyname = Consolidator::where('code', $locationcode)->value('company_name');
                    }),
                 TextColumn::make('invoice')
                    ->searchable()
                    ->label('Invoice'),
                TextColumn::make('invdata.container.batch_no')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->label('Batch No'),
                TextColumn::make('invdata.container.batch_year')
                    ->searchable()
                    ->label('Batch Year'),
                TextColumn::make('invdata.container.container_no')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->label('Container No'),
                TextColumn::make('invdata.sender_name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Sender'),
                TextColumn::make('invdata.receiver_name')
                    ->label('Receiver'),
                TextColumn::make('invdata.receiver_address')
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

                TextColumn::make('invdata.receiver_province')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Province'),
                TextColumn::make('invdata.receiver_city')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('City'),
                TextColumn::make('invdata.receiver_barangay')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Barangay'),
                TextColumn::make('invdata.boxtype')
                    ->label('Box Type'),
                TextColumn::make('invdata.routearea.description')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Route Area')
            ])
            ->filters([
                SelectFilter::make('is_delivered')
                    ->label('Is Delivered')
                    ->options([
                        1 => 'Yes',
                        0 => 'No',
                    ])->default(0),
                SelectFilter::make('routearea_id')
                    ->label('Route')
                    ->relationship('invoice.routearea', 'description'),
                SelectFilter::make('deliverylog_id')
                    ->label('Trip Number')
                    ->relationship('deliverylog', 'trip_number', fn(Builder $query) => $query->where('logistichub_id', Auth::user()->logistichub_id)),

                SelectFilter::make('container_id')
                    ->label('Batch / Container')
                    ->relationship(
                        name: 'invoice.container',
                        titleAttribute: 'container_no'

                    )
                    ->searchable()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(function (Model $record) {
                        return "{$record->container_no} {$record->batch_no} {$record->batch_year}";
                    })
            ])->deferFilters(false)
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make()
                        ->slideOver()
                        ->modal()
                        ->label('View')
                        ->color('primary')
                        ->icon(Heroicon::Eye)
                         ->hidden(fn($record) => empty($record->delivery_picture)),

                    Action::make('Edit')
                        ->label('Edit Picture')
                        ->color('info')
                        ->icon(Heroicon::PencilSquare)
                        ->hidden(fn($record) => empty($record->delivery_picture))
                        ->fillForm(fn(Model $record): array => [

                            'delivery_picture' => $record->delivery_picture,
                        ])
                        ->schema([
                            FileUpload::make('delivery_picture')
                                ->label('Delivery Picture')
                                ->multiple()
                                ->panelLayout('grid')
                                ->uploadingMessage('Uploading attachment...')
                                ->image()
                                ->openable()
                                ->disk('public')
                                ->directory(function (Model $record) {
                                    return $record->invoice;
                                })
                                ->visibility('private')
                                ->required()
                                ->removeUploadedFileButtonPosition('right')
                        ])
                        ->action(function (array $data, Model $record): void {
                            Tripinvoice::where('id', $record->id)
                                ->update([
                                    'delivery_picture' => $data['delivery_picture'],
                                ]);
                        }),
                    Action::make('Picture')
                        ->label('Add Picture')
                        ->color('danger')
                        ->icon(Heroicon::Camera)
                        ->hidden(fn($record) => !empty($record->delivery_picture))
                        ->schema([
                            FileUpload::make('delivery_picture')
                                ->label('Delivery Picture')
                                ->multiple()
                                ->panelLayout('grid')
                                ->uploadingMessage('Uploading ...')
                                ->image()
                                ->openable()
                                ->disk('public')
                                ->directory(function (Model $record) {
                                    return $record->invoice;
                                })
                                ->visibility('private')
                                ->required()
                                ->removeUploadedFileButtonPosition('right')
                            // ->minFiles(6),
                        ])
                        ->action(function (array $data, Model $record): void {

                            Tripinvoice::where('id', $record->id)
                                ->update([
                                    'delivery_picture' => $data['delivery_picture'],
                                    'is_delivered' => true
                                ]);
                        })
                ])
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
