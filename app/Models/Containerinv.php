<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Containerinv extends Model
{
    protected $table = 'invoices';

     public function container ()
    {
        return $this->belongsTo(Container::class);
    }
     public function routearea ()
    {
        return $this->belongsTo(Routearea::class);
    }
}
