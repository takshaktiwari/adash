<?php

namespace App\Models;

use Takshak\Adash\Models\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Takshak\Imager\Facades\Placeholder;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $guarded = [];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The roles that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function profileImg()
    {
        if (!empty($this->profile_img)) {
            if (Str::is('https://*', $this->profile_img)) {
                return $this->profile_img;
            }
            if (Storage::disk('public')->exists($this->profile_img)) {
                return storage($this->profile_img);
            }
        }

        $fileName = 'users/' . time() . '.jpg';
        $filePath = Storage::disk('public')->path($fileName);
        return Placeholder::dimensions(150, 150)
            ->background(rand(100, 999))
            ->text(substr($this->name, 0, 2), ['color' => '#fff', 'size' => 60])
            ->save($filePath)->saveModel($this, 'profile_img', $fileName)
            ->url();
    }

    public function getFirstNameAttribute()
    {
        return explode(' ', $this->name)[0];
    }

    public function dashboardRoute()
    {
        return route('admin.dashboard');
    }
}
