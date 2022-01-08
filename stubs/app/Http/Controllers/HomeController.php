<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard()
    {
        if (auth()->user()->roles->contains('name', 'admin')) {
            return redirect()->route('admin.dashboard');

        }else{
            return redirect()->route('user.dashboard');
            
        }
    }

}