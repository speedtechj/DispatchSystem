<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Inventory extends Model
{
    //
     public $table = 'invoices';
     public function tripInvoices() {
        return $this->hasMany( Tripinvoice::class, 'invoice_id', 'id');
    }
    public function container () {
        return $this->belongsTo( Container::class, 'container_id', 'id' );
    }
    public function warehouse () {
        return $this->belongsTo( Warehouse::class, 'warehouse_id', 'id' );
    }
    public function deliverylogs() {
        return $this->hasManyThrough( DeliveryLog::class, TripInvoice::class );
    }
     public function consolidator() {
        return $this->belongsTo(
            Consolidator::class,
            'location_code', // FK on invoices
            'code'           // UNIQUE key on consolidators
        );

    }
     public function scopeByReceiverProvince(Builder $query): Builder
    {
        return $query->whereHas('tripInvoices', fn ($q) => $q->where('is_loaded', 0))
        ->with(['tripInvoices' => fn ($q) => $q->where('is_loaded', 0)]);

    }
}
