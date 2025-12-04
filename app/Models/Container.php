<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    //
    protected $casts = [
        'container_picture' => 'array',
    ];
    public function user ()
    {
        return $this->belongsTo(User::class);
    }
    public function consolidator ()
    {
        return $this->belongsTo(Consolidator::class);
    }
    public function invoices(){
        return $this->hasMany(Invoice::class);
    }

     public function containerinvoices(){
        return $this->hasMany(Containerinv::class);
    }
}
