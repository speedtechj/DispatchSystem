<?php

namespace App\Filament\Warehouse\Resources\Inventories\Widgets;

use App\Models\Inventory;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Reactive;

class InventoryAllWidget extends StatsOverviewWidget
{
    #[Reactive]
    public array $provinces = [];
    protected ?string $heading = 'Warehouse Inventory Overview';

    protected static bool $isLazy = false;
    protected function getStats(): array
    {
       $query = Inventory::byReceiverProvince()
            ->where('is_verified', 1)
            ->where('warehouse_id', Auth::user()->warehouse_id)
            ->whereHas('tripInvoices', fn($q) => $q->where('is_loaded', 0));

        if (! empty($this->provinces)) {
            $query->whereIn('receiver_province', $this->provinces);
        }



        return [
            Stat::make('Total Boxes on Floor', number_format($query->count()))
             ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
        ];
    }
}
