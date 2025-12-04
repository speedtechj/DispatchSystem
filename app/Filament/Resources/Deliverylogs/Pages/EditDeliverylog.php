<?php

namespace App\Filament\Resources\Deliverylogs\Pages;

use App\Filament\Resources\Deliverylogs\DeliverylogResource;
use App\Models\Tripinvoice;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDeliverylog extends EditRecord
{
    protected static string $resource = DeliverylogResource::class;

    protected function getHeaderActions(): array
    {
        return [
           // DeleteAction::make(),
        ];
    }
     protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function afterSave(): void
    {
        $newlogistichubid = $this->data['assigned_to'];
        $tripdatas = Tripinvoice::where('deliverylog_id', $this->data['id'])->get();
        foreach ($tripdatas as $tripdata){
             $tripdata->update([
                'logistichub_id' => $newlogistichubid,
             ]);
        }
    }
    
}
