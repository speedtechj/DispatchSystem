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

     //  dd($this->old);

        $newlogistichubid = $this->data['assigned_to'];
        $tripdatas = Tripinvoice::where('deliverylog_id', $this->data['id'])->get();
        foreach ($tripdatas as $tripdata){
             $tripdata->update([
                'logistichub_id' => $newlogistichubid,
             ]);
        }
    }
    // protected function beforeSave(): void
    // {
         
    //     $oldid = Truck::where('id', $this->record->truck_id)->first();
    //     $this->old = $oldid->id;
       
    // }
    
}
