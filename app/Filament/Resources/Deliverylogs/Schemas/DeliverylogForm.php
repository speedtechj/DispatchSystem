<?php

namespace App\Filament\Resources\Deliverylogs\Schemas;

use App\Models\Tripinvoice;
use App\Models\Truck;
use Filament\Forms\Components\Concerns\HasHelperText;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Callout;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Enums\IconSize;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class DeliverylogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Callout::make('Pro tip')
                    ->description('Before creating a delivery log, always check the truck size and its capacity first. Identify how many boxes the truck can safely load based on its limit.
                     Proper capacity planning ensures safe delivery, avoids delays, and prevents overloading issues.')
                    ->icon(Heroicon::OutlinedLightBulb)
                    ->color('primary')
                    ->extraAttributes(['class' => 'text-color:red'])
                    ->iconColor('primary')->columns(4),
                Select::make('truck_id')
                    // ->required()
                    ->label('Truck')
                    ->options(
                        Truck::query()
                            ->where('is_assigned', 0)
                            ->where('logistichub_id', '=', Auth::user()->logistichub_id)
                            ->where('is_active', 1)
                            ->pluck('plate_no', 'id')
                    )
                    ->getOptionLabelUsing(
                        fn($value): ?string =>
                        Truck::find($value)?->plate_no
                    )
                    ->searchable()
                    ->preload()
                    ->Hidden(function ($record) {
                        $count_totalinvoice = Tripinvoice::where('deliverylog_id', $record?->id)->count();
                        $count_totalloaded = Tripinvoice::where('deliverylog_id', $record?->id)->where('is_loaded', true)->count();

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
                    ->native(false)
                    ->closeOnDateSelection(true)
                    ->required(),
                DatePicker::make('departure_date')
                    ->native(false)
                    ->closeOnDateSelection(true)
                    ->required(),
                Select::make('assigned_to')
                    ->label('Going To')
                    ->options(\App\Models\Logistichub::query()->pluck('hub_name', 'id'))
                    ->searchable()
                    ->preload(),
                TextInput::make('waybill_number')
                    ->label('Waybill No. / Containe No.')
                    ->helperText('Enter the waybill number & container number format: WB-12345 / CN-12345'),
                DatePicker::make('delivery_date')
                    ->label('Delivered Date')
                    ->native(false)
                    ->closeOnDateSelection(true)

            ]);
    }
}
