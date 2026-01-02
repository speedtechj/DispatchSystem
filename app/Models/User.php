<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use Filament\Facades\Filament;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Auth;
use Filament\Models\Contracts\HasName;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser, HasName, HasAvatar
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
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
    public function canAccessPanel(Panel $panel): bool
    {
       
       $isadmin = $this->is_admin;
      
       
        // dd(asset($this->profile_picture));

        if ($panel->getId() === 'admin' &&  $isadmin == true && $this->panelcategory->code === 'adm') {
            return true;
        } elseif ($panel->getId() === 'company'  && $this->panelcategory->code === 'co' || $this->panelcategory->code  === 'adm') {
            return true;
        } elseif ($panel->getId() === 'delivery' && $isadmin == false && $this->panelcategory->code === 'drv') {
            return true;
    //     } elseif ($panel->getId() === 'dispatcher' && $isadmin == false && Auth::user()->panelcategory->code === 'dispatcher') {
    //  return true;
            // return str_ends_with($this->is_active, 1);
        } else {
        return false;

        }
       
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
       
     return $this->profile_picture
    ? Storage::disk('public')->$this->profile_picture
    : null;
        // $profilePicture = is_array($this->profile_picture) ? ($this->profile_picture['path'] ?? null) : $this->profile_picture;
        // // dd($profilePicture);
        // return $profilePicture ? asset($profilePicture) :
        //  'https://ui-avatars.com/api/?name=' . urlencode($this->full_name);
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
    
}
