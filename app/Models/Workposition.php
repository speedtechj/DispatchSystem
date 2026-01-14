<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workposition extends Model
{
     /**
     * Get the user that owns the Workposition
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function panelcategory()
    {
        return $this->belongsTo(Panelcategory::class);
    }
}
