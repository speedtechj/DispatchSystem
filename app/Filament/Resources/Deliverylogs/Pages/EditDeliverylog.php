<?php

namespace App\Filament\Resources\Deliverylogs\Pages;

use App\Filament\Resources\Deliverylogs\DeliverylogResource;
use App\Models\Tripinvoice;
use App\Models\Truck;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDeliverylog extends EditRecord
{
    protected static string $resource = DeliverylogResource::class;
  //  Public  $old;
  //  Public $new;
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
        $newtruckid = $this->data['truck_id'];

        Truck::where('id', $newtruckid)->update([
            'is_assigned' => 1,
        ]);
        $oldtruckid = session()->get('old_truck_id');
        Truck::where('id', $oldtruckid)->update([
            'is_assigned' => 0,
        ]);


        $newlogistichubid = $this->data['assigned_to'];
        $tripdatas = Tripinvoice::where('deliverylog_id', $this->data['id'])->get();
        foreach ($tripdatas as $tripdata){
             $tripdata->update([
                'logistichub_id' => $newlogistichubid,
             ]);
        }
    }
    protected function beforeSave(): void
    {
        session()->put('old_truck_id', $this->record->truck_id);
       
       
    }
    
}
