<?php

namespace App\Filament\Resources\Inventories\Widgets;

use App\Filament\Warehouse\Resources\Inventories\Pages\ListInventories;
use App\Models\Inventory;
use App\Models\Warehouse;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Livewire\Attributes\Reactive;

class InvetoryAllWidget extends StatsOverviewWidget
{
    // use InteractsWithPageTable;

    // protected static bool $isLazy = false;
    // protected ?string $pollingInterval = '2s';
    protected ?string $heading = 'Inventory Overview';

    #[Reactive]
    public array $provinces = [];
    public array $warehouses = [];
    protected static bool $isLazy = false;
    protected function getStats(): array
    {
        // $query = Inventory::byReceiverProvince()
        //     ->where('is_verified', 1)
        //     ->whereHas('tripInvoices', fn($q) => $q->where('is_loaded', 0));

        // if (! empty($this->provinces)) {
        //     $query->whereIn('receiver_province', $this->provinces);
        // }



        // return [
        //     Stat::make('Total Boxes on Floor', number_format($query->count())),
        // ];
        // 1. Get the warehouses first (id + name)
    $warehouses = Warehouse::query()
        ->when(! empty($this->warehouses), fn ($q) => $q->whereIn('id', $this->warehouses))
        ->orderBy('name')
        ->get(['id', 'name']);

    // 2. Base query with the shared filters
    $base = Inventory::byReceiverProvince()
        ->where('is_verified', 1)
        ->whereHas('tripInvoices', fn ($q) => $q->where('is_loaded', 0));

    if (! empty($this->provinces)) {
        $base->whereIn('receiver_province', $this->provinces);
    }

    // 3. One stat per warehouse
    $stats = [];
    $total = 0;

    foreach ($warehouses as $warehouse) {
        $count = (clone $base)
            ->where('warehouse_id', $warehouse->id)
            ->count();

        $total += $count;

        $stats[] = Stat::make($warehouse->name . ' - Boxes on Floor', number_format($count))
        ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success');
    }

    // 4. Total stat first
    array_unshift($stats, Stat::make('Total Boxes on Floor', number_format($base->count()))
    ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('danger'),);

    return $stats;
    }

}
