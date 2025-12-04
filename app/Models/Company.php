<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $casts = [
        'company_document' => 'array',
        'company_picture' => 'array',
    ];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function logistichubs ()
    {
        return $this->belongsTo(Logistichub::class);
    }


}
