<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Takshak\Adash\Traits\Controllers\Admin\BlogCommentTrait;

class BlogCommentController extends Controller
{
    use BlogCommentTrait;
    
}
