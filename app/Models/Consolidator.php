<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consolidator extends Model
{
    protected $casts = [
        'company_document' => 'array',
        'logo'=> 'array',
    ];
    //
    public function user ()
    {
        return $this->belongsTo(User::class);
    }
}
