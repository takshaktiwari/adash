<?php

namespace App\Models;

use App\Models\Address;
use App\Models\Role;
use App\Models\Wishlist;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

    public function profileImg()
    {
        if (!empty($this->profile_img)) {
            return \Str::is('https://*', $this->profile_img)
                        ? $this->profile_img
                        : url('storage/app/public/'.$this->profile_img);
        }else{
            $fileName = 'users/'.time().'.jpg';
            $filePath = \Storage::disk('public')->path($fileName);
            return \Placeholder::dimensions(150, 150)
                    ->background(rand(100, 999))
                    ->text(substr($this->name, 0, 2), ['color' => '#fff', 'size' => 60])
                    ->save($filePath)->saveModel($this, 'profile_img', $fileName)
                    ->url();
        }
    }
    
    public function getFirstNameAttribute()
    {
        return explode(' ', $this->name)[0];
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function dashboardRoute()
    {
        return route('admin.dashboard');
    }
    
}
