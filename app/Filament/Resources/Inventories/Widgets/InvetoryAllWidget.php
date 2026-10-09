<?php

namespace App\Filament\Resources\Inventories\Widgets;

use App\Filament\Warehouse\Resources\Inventories\Pages\ListInventories;
use App\Models\Inventory;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Livewire\Attributes\Reactive;

class InvetoryAllWidget extends StatsOverviewWidget
{
   // use InteractsWithPageTable;

    // protected static bool $isLazy = false;
    // protected ?string $pollingInterval = '2s';
    #[Reactive]
    public array $provinces = [];

    protected static bool $isLazy = false;
    protected function getStats(): array
    {
        $query = Inventory::byReceiverProvince()
            ->where('is_verified', 1)
            ->whereHas('tripInvoices', fn ($q) => $q->where('is_loaded', 0));

        if (! empty($this->provinces)) {
            $query->whereIn('receiver_province', $this->provinces);
        }

        return [
            Stat::make('Total Boxes on Floor', number_format($query->count())),
        ];
    }
    // protected function getTablePage(): string
    // {
    //     return ListInventories::class;
    // }
    // protected function getStats(): array
    // {
    //     $count = $this->getPageTableQuery()->where('is_verified', 1)
    //         ->whereHas('tripInvoices', fn ($q) => $q->where('is_loaded', 0))
    //         ->with(['tripInvoices' => fn ($q) => $q->where('is_loaded', 0)])
    //         ->count();

    //     return [
    //         Stat::make('Total Boxes on Floor', number_format($count)),
    //     ];
    // }
}
