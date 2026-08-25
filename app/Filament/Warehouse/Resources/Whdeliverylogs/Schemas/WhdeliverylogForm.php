<?php

namespace App\Filament\Warehouse\Resources\Whdeliverylogs\Schemas;

use App\Models\Truck;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class WhdeliverylogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('truck_id')
                    ->searchable()
                    ->preload()
                    ->options(
                        Truck::query()
                            ->where('is_assigned', 0)
                            ->where('logistichub_id', '=', Auth::user()->logistichub_id)
                            ->where('is_active', 1)
                            ->pluck('plate_no', 'id')
                    )
                    ->label('Truck')
                    ->required(),
                Select::make('warehouse_id')
                    ->searchable()
                    ->preload()
                    ->relationship('warehouse', 'name', modifyQueryUsing: fn (Builder $query) => $query->where('id', '!=', Auth::user()->warehouse_id))
                    ->label('Warehouse')
                    ->required(),
                DatePicker::make('departure_date')
                    ->native()
                    ->required(),
                DatePicker::make('delivery_date')
                    ->native()
                    ->required(),
            ]);
    }
}
