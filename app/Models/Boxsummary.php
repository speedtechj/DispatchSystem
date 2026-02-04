<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Boxsummary extends Model
{
    protected $table = 'invoices';
     public function container () {
        return $this->belongsTo( Container::class );
    }

    public function user () {
        return $this->belongsTo( User::class );
    }

    public function routearea () {
        return $this->belongsTo( Routearea::class );
    }

    protected function FullAddress(): Attribute {
        return new Attribute(
            get: fn () => $this->receiver_address .' ' . $this->receiver_province . ' ' . $this->receiver_city . ' ' . $this->receiver_barangay
        );
    }

    public function consolidator() {
        return $this->belongsTo(
            Consolidator::class,
            'location_code', // FK on invoices
            'code'           // UNIQUE key on consolidators
        );

    }

    public function tripInvoices() {
        return $this->hasMany( Tripinvoice::class );
    }

    public function deliverylogs() {
        return $this->hasManyThrough( DeliveryLog::class, TripInvoice::class );
    }
}
