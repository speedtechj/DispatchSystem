<?php

namespace App\Filament\Resources\Deliveryinvs\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use App\Filament\Resources\Deliveryinvs\DeliveryinvResource;

class ListDeliveryinvs extends ListRecords
{
    protected static string $resource = DeliveryinvResource::class;

    protected function getHeaderActions(): array
    {
        return [
       //     CreateAction::make(),
        ];
    }
    // public function getTabs(): array
    // {
    //     return [
    //             'Completed Delivered' => Tab::make('Completed Delivered')
    //                 ->modifyQueryUsing(function ( $query){
    //                     return $query->where('is_delivered', true);
    //                 }),
    //     ];
    // }
}
