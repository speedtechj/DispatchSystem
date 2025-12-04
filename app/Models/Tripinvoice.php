<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tripinvoice extends Model
{
    //
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
}
