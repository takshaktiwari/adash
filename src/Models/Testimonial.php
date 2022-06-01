<?php

namespace Takshak\Adash\Models;

use Database\Factories\TestimonialFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function newFactory()
    {
        return TestimonialFactory::new();
    }

    public function avatarUrl()
    {
        return $this->avatar
            ? storage($this->avatar)
            : 'https://ui-avatars.com/api/?size=300&name=' . $this->title;
    }
}
