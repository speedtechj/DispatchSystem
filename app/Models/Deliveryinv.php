<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deliveryinv extends Model
{
    public $table = 'tripinvoices';
     protected function casts(): array
    { 
        return [
            'delivery_picture' => 'array',
        ];
    }
    public function deliverylog()
    {
        return $this->belongsTo(Deliverylog::class);
    }
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
    public function logistichub()
    {
         return $this->belongsTo(Logistichub::class);
    }
   public function routearea()
    {
        return $this->hasOneThrough(
            Routearea::class,   // Final model
            Invoice::class, // Intermediate model
            'id',           // Foreign key on Invoice table
            'id',           // Foreign key on Route table
            'invoice_id',   // Local key on TripInvoice
            'routearea_id'      // Local key on Invoice
        );
    }
    public function scopeUnloadedinv($query)
    {
        return $query->where('is_loaded', true);
    }
    public function scopeHubinv($query)
    {
        return $query->where('is_loaded_hub', true);
    }
}
