<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Whdeliverylog extends Model
{
    protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        $warehousedata = Warehouse::where('id', Auth::user()->warehouse_id)->first();
        $count = $warehousedata->nextTripNumber();
        $model->trip_number = $warehousedata->id.$count;

    });
}
     public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
    public function whtripinvoices()
    {
        return $this->hasMany(Whtripinvoice::class);
    }
}
