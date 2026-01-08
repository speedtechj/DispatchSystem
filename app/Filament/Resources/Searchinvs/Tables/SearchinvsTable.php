<?php

namespace App\Filament\Resources\Searchinvs\Tables;

use Filament\Tables\Table;
use App\Models\Tripinvoice;
use App\Models\Consolidator;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\Deliverylogs\DeliverylogResource;

class SearchinvsTable {
    public static function configure( Table $table ): Table {
        return $table
        ->columns( [
            TextColumn::make( 'container.container_no' )
            ->sortable(),
            TextColumn::make( 'company')
            ->label('Company')
            ->toggleable( isToggledHiddenByDefault: true )
            ->getStateUsing(function($record){
                $company = Consolidator::where('code',$record->location_code )->first();
                return $company->company_name;
            }),
            
          //  ->url(fn (Model $record) => DeliverylogResource::getUrl('edit', ['record' => $record->deliverylog_id])),,
            TextColumn::make( 'tripno' )
            ->label('Trip Number')
          ->getStateUsing(function($record){
               $tripinvoice = Tripinvoice::where('invoice_id',$record->id)->first();
               return $tripinvoice->deliverylog->trip_number ?? 'Not Assigned';
           }) 
            ->url(function($record){
                $tripinvoice = Tripinvoice::where('invoice_id',$record->id)->first();
                if($tripinvoice !== null){
                   return DeliverylogResource::getUrl('edit', ['record' => $tripinvoice->deliverylog->id]) ?? 'not assigned';
                }
            })
            ->color('primary'),
            TextColumn::make( 'invoice' )
            ->searchable(isIndividual: true, isGlobal: false),
            TextColumn::make( 'batchno' )
             ->toggleable( isToggledHiddenByDefault: true ),
            TextColumn::make( 'sender_name' )
            ->searchable(isIndividual: true, isGlobal: false),
            TextColumn::make( 'receiver_name' )
            ->searchable(isIndividual: true, isGlobal: false),
            TextColumn::make( 'receiver_address' )
            ->toggleable( isToggledHiddenByDefault: true ),
            TextColumn::make( 'receiver_province' )
            ->toggleable( isToggledHiddenByDefault: true ),
            TextColumn::make( 'receiver_city' )
            ->toggleable( isToggledHiddenByDefault: true ),
            TextColumn::make( 'receiver_barangay' )
            ->toggleable( isToggledHiddenByDefault: true ),
            TextColumn::make( 'receiver_mobile_no' )
            ->toggleable( isToggledHiddenByDefault: true )
           ->searchable(isIndividual: true, isGlobal: false),
            TextColumn::make( 'receiver_home_no' )
            ->toggleable( isToggledHiddenByDefault: true )
            ->searchable(isIndividual: true, isGlobal: false),
            TextColumn::make( 'boxtype' )
            ->toggleable( isToggledHiddenByDefault: true )
            ->searchable(isIndividual: true, isGlobal: false),
            TextColumn::make( 'routearea.description' )
            ->toggleable( isToggledHiddenByDefault: true )
            ->sortable(),
            IconColumn::make( 'is_verified' )
            ->toggleable( isToggledHiddenByDefault: true )
            ->boolean(),
            TextColumn::make( 'created_at' )
            ->dateTime()
            ->sortable()
            ->toggleable( isToggledHiddenByDefault: true ),
            TextColumn::make( 'updated_at' )
            ->dateTime()
            ->sortable()
            ->toggleable( isToggledHiddenByDefault: true ),
        ] )->searchOnBlur()
            ->persistSearchInSession()
        ->persistColumnSearchesInSession()
        ->filters( [
            //
        ] )
        ->recordActions( [
            // EditAction::make(),
        ] )
        ->toolbarActions( [
            BulkActionGroup::make( [
                DeleteBulkAction::make(),
            ] ),
        ] );
    }
}
