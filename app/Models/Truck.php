<?php

namespace App\Models;

use App\Models\Truckcrew;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    public function user ()
    {
        return $this->belongsTo(User::class);
    }
   public function truckcrews ()
    {
        return $this->hasMany(Truckcrew::class);
    }
}
