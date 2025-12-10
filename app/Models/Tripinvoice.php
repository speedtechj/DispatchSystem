<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
class Tripinvoice extends Model
{
    //
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
   public function route()
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
    
}
