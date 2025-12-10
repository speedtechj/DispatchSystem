<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Truckcrew extends Model
{
    //
    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    
}
