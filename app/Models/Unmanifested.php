<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unmanifested extends Model
{
    protected function casts(): array
    {
        return [
            
            'attachment_pic' => 'array'
        ];
    }
     public function container()
    {
        return $this->belongsTo(Container::class);
    }
     public function consolidator()
    {
        return $this->belongsTo(Consolidator::class);
    }
}
