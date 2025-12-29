<?php

namespace App\Filament\Widgets;

use App\Models\Invoice;
use App\Models\Container;
use Livewire\Attributes\On;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Unloaded extends StatsOverviewWidget
{
    public ?int $containerId = null;
    public ?string $totalboxes = null;
    public ?string $total_unloaded = null;

    #[On('container-selected')]
    public function updateContainer($containerId): void
    {
        $this->containerId = $containerId;
        $this->total_unloaded = Invoice::where('container_id', $containerId)
            ->where('is_verified', true)
            ->count();
        $this->totalboxes = Container::where('id', $containerId)
            ->first()->total_boxes;
            
     
        
       
    }

    
    protected function getStats(): array
    {
        return [
             Stat::make('Total Unloaded', $this->total_unloaded ?? 0),
            Stat::make(' Boxes', $this->totalboxes ?? 0),
        ];
    }
}
