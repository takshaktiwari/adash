<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function banner($value='')
    {
        return asset('storage/'.$this->banner);
    }

    public function scopeActive($query='')
    {
        return $query->where('status', true);
    }
}
