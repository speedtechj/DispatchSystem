<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Companyprofile extends Model
{
    protected $casts = [
        'company_logo' => 'array',
    ];
}
