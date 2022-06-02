<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function dashboard()
    {
        $users_count  = User::count();
        return view('admin.dashboard', compact('users_count'));
    }
}
