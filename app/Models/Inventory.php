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
     public function scopeByReceiverProvince(Builder $query): Builder
    {
        return $query->where('is_verified', 1)
        ->whereHas('tripInvoices', fn ($q) => $q->where('is_loaded', 0))
        ->with(['tripInvoices' => fn ($q) => $q->where('is_loaded', 0)]);

    }
}
