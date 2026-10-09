<?php

namespace App\Filament\Warehouse\Resources\Inventories\Widgets;

use App\Models\Inventory;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class InventoryAllWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
       $count = Inventory::where('is_verified', 1)
            ->where('warehouse_id',Auth::user()->warehouse_id)
            ->whereHas('tripInvoices', fn ($q) => $q->where('is_loaded', 0))
            ->with(['tripInvoices' => fn ($q) => $q->where('is_loaded', 0)])
            ->count();

        return [
            Stat::make('Total Boxes on Floor', number_format($count)),
        ];
    }
}
