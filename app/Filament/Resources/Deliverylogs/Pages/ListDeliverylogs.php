<?php

namespace App\Filament\Resources\Deliverylogs\Pages;

use App\Filament\Resources\Deliverylogs\DeliverylogResource;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ListDeliverylogs extends ListRecords
{
    protected static string $resource = DeliverylogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
    public function mount(): void
    {
       // dd(Auth::user()->getRoleNames());
        parent::mount();

        Notification::make()
            ->title('Please fill up and complete all active delivery logs before creating a new delivery log.')
         //    ->body(Str::markdown('<div style="color:#F5BA07;font-weight:bold;font-size:15px;">After typing, press Tab Key or Click Search icon to begin the search</div>'))
            ->persistent()
            ->success()
            ->send();
    }

}
