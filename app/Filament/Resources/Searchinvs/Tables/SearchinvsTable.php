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
            ->label('Container No')
            ->sortable(),
            TextColumn::make( 'company')
            ->label('Company')
            ->toggleable( isToggledHiddenByDefault: true )
            ->getStateUsing(function($record){
                $company = Consolidator::where('code',$record->location_code )->first();
                return $company->company_name;
            }),
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
            ->label('Invoice')
            ->searchable(isIndividual: true, isGlobal: false),
            TextColumn::make( 'batchno' )
            ->label('Batch No')
             ->toggleable( isToggledHiddenByDefault: true ),
            TextColumn::make( 'sender_name' )
            ->label('Sender Name')
            ->searchable(isIndividual: true, isGlobal: false),
            TextColumn::make( 'receiver_name' )
            ->label('Receiver Name')
            ->searchable(isIndividual: true, isGlobal: false),
            TextColumn::make( 'receiver_address' )
            ->label('Receiver Address')
            ->toggleable( isToggledHiddenByDefault: true ),
            TextColumn::make( 'receiver_province' )
            ->label('Receiver Province')
            ->toggleable( isToggledHiddenByDefault: true ),
            TextColumn::make( 'receiver_city' )
            ->label('Receiver City')
            ->toggleable( isToggledHiddenByDefault: true ),
            TextColumn::make( 'receiver_barangay' )
            ->label('Receiver Barangay')
            ->toggleable( isToggledHiddenByDefault: true ),
            TextColumn::make( 'receiver_mobile_no' )
            ->label('Receiver Mobile No')
            ->toggleable( isToggledHiddenByDefault: true )
           ->searchable(isIndividual: true, isGlobal: false),
            TextColumn::make( 'receiver_home_no' )
            ->label('Receiver Home No')
            ->toggleable( isToggledHiddenByDefault: true )
            ->searchable(isIndividual: true, isGlobal: false),
            TextColumn::make( 'boxtype' )
            ->label('Box Type'),
            TextColumn::make( 'routearea.description' )
            ->label('Route Area')
            ->toggleable( isToggledHiddenByDefault: true )
            ->sortable(),
            IconColumn::make( 'is_verified' )
            ->label('Verified')
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
