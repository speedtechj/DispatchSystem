<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function nextTripNumber()
{
    $this->trip_no += 1;
    $this->save();

    return $this->trip_no;
}
}
