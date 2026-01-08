<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Searchinv extends Model
{
    public $table = 'invoices';

    public function container()
    {
       return $this->belongsTo(Container::class);
    }


    public function routearea()
    {
        return $this->belongsTo(Routearea::class);
    }
    public function tripinvoice()
    {
        return $this->belongsTo(Tripinvoice::class);
    }


}
