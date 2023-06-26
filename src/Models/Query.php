<?php

namespace Takshak\Adash\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'others'    =>  'collection'
    ];
}
