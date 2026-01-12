<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Truckteam extends Model
{
    //
   protected $table = 'users';

   protected $appends = ['full_name'];
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'profile_picture' => 'array'
        ];
    }
    public function getFilamentName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
    public function getFilamentAvatarUrl(): ?string
    {
       
        $profilePicture = is_array($this->profile_picture) ? ($this->profile_picture['path'] ?? null) : $this->profile_picture;
        return $profilePicture ? asset($profilePicture) :
         'https://ui-avatars.com/api/?name=' . urlencode($this->full_name);
     }

     public function panelcategory ()
    {
        return $this->belongsTo(Panelcategory::class);
    }
     public function company ()
    {
        return $this->belongsTo(Company::class);
    }
    public function workposition ()
    {
        return $this->belongsTo(Workposition::class);
    }
    public function logistichub ()
    {
        return $this->belongsTo(Logistichub::class);
    }

     public function truck()
    {
        return $this->belongsTo(Truck::class);
    }
}
