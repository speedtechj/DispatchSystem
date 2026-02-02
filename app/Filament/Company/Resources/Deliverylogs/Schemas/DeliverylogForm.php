<?php

namespace App\Filament\Company\Resources\Deliverylogs\Schemas;

use App\Models\Truck;
use App\Models\Tripinvoice;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;

class DeliverylogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('truck_id')
                    ->required()
                    ->label('Truck')
                    ->options(
                        truck::query()
                            ->where('is_assigned', 0)
                            ->where('is_active', 1)
                            ->where('logistichub_id', '=', Auth::user()->logistichub_id)
                            ->pluck('plate_no', 'id')
                    )->getOptionLabelUsing(
                        fn($value): ?string =>
                        Truck::find($value)?->plate_no
                    )
                    ->searchable()
                    ->preload()
                    ->Hidden(function ($record) {
                //dd($record->id);
                        $count_totalinvoice = Tripinvoice::where('deliveryloghub_id', $record?->id)->count();
                        $count_totalloaded = Tripinvoice::where('deliveryloghub_id', $record?->id)->where('is_loaded_hub', true)->count();
                   //     dd($count_totalinvoice,$count_totalloaded);

                        if ($count_totalloaded > 0) {
                            if ($count_totalinvoice == $count_totalloaded) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }),
                TextInput::make('trip_day')
                    ->required()
                    ->numeric(),
                DatePicker::make('eta')
                    ->required(),
                DatePicker::make('departure_date')
                    ->required(),
                DatePicker::make('delivery_date'),
                TextInput::make('waybill_number'),
               
                
                
            ]);
    }
}
