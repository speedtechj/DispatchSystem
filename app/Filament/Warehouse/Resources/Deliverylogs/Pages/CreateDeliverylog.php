<?php

namespace App\Filament\Warehouse\Resources\Deliverylogs\Pages;

use App\Filament\Warehouse\Resources\Deliverylogs\DeliverylogResource;
use App\Models\Truck;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateDeliverylog extends CreateRecord
{
    protected static string $resource = DeliverylogResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['logistichub_id'] = Auth::user()->logistichub_id;
        $data['user_id'] = Auth::id();

        return $data;

    }
    protected function afterCreate(): void
    {
        $newtruckid = $this->data['truck_id'];

        Truck::where('id', $newtruckid)->update([
            'is_assigned' => 1,
        ]);
    }
}
