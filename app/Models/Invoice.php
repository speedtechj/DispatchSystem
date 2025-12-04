<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use PhpParser\Node\Expr\Cast;

class Invoice extends Model
{
   
    public function container ()
    {
        return $this->belongsTo(Container::class);
    }
   public function user ()
    {
        return $this->belongsTo(User::class);
    }
     public function routearea ()
    {
        return $this->belongsTo(Routearea::class);
    }

   protected function FullAddress(): Attribute
    {
        return new Attribute(
            get: fn () => $this->receiver_address .' ' . $this->receiver_province . ' ' . $this->receiver_city . ' ' . $this->receiver_barangay
        );
    }
}
