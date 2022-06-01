<?php

namespace Takshak\Adash\Models;

use Database\Factories\PageFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function newFactory()
    {
        return PageFactory::new();
    }

    public function banner()
    {
        return storage($this->banner);
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('status', true);
    }
}
