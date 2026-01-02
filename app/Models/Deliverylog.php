<?php

namespace App\Models;

use App\Models\Logistichub;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deliverylog extends Model
{
    //

    protected static function boot()
{
    parent::boot();
    
    static::creating(function ($model) {
        $hubcode = logistichub::where('id', Auth::user()->logistichub_id)->first();
        $today = now()->format('Ym');
        $count = $hubcode->nextTripNumber();
      //  dd(today());
        $model->trip_number = $today.$hubcode->hub_code.$count;
    });

    // static::updating(function (Logistichub $model) {
    //     $hubcode = logistichub::where('id', Auth::user()->logistichub_id)->first();
    //     $hubcode->trip_counter += 1;
    //     $hubcode->save();
    // });

    
}
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }
    public function logistichub()
    {
        return $this->belongsTo(Logistichub::class);
    }
    public function tripinvoices()
    {
        return $this->hasMany(Tripinvoice::class);
    }
    
   
}
