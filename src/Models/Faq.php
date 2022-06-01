<?php

namespace Takshak\Adash\Models;

use Database\Factories\FaqFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function newFactory()
    {
        return FaqFactory::new();
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('status', true);
    }
}
