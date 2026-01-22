<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Routeinvoice extends Model
{
    protected $table = 'invoices';

    public function routearea()
    {
        return $this->belongsTo(Routearea::class);
    }
    public function tripinvoices()
    {
        return $this->hasMany(Tripinvoice::class, 'invoice_id');
    }
    
    
}
