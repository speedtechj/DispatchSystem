<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logistichub extends Model
{
    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function nextTripNumber()
{
    $this->trip_counter += 1;
    $this->save();

    return $this->trip_counter;
}
}
