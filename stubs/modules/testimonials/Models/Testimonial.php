<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function avatarUrl()
    {
        return $this->avatar
            ? storage($this->avatar)
            : 'https://ui-avatars.com/api/?size=300&name=' . $this->title;
    }
}
