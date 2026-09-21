<?php

namespace App\Filament\Resources\Inventories\Widgets;

use App\Models\Inventory;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class InvetoryAllWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $count = Inventory::where('is_verified', 1)
            ->whereHas('tripInvoices', fn ($q) => $q->where('is_loaded', 0))
            ->with(['tripInvoices' => fn ($q) => $q->where('is_loaded', 0)])
            ->count();

        return [
            Stat::make('Total Boxes on Floor', number_format($count)),
        ];
    }
}
