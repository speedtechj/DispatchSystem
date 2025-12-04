<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    public function user ()
    {
        return $this->belongsTo(User::class);
    }
   public function truckcrew ()
    {
        return $this->belongsTo(Truckcrew::class);
    }
}
