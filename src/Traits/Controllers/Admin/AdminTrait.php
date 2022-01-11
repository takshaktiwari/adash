<?php

namespace Takshak\Adash\Traits\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;

trait AdminTrait {

	public function index($value='')
	{
	    $users_count  = \App\Models\User::count();
	    return view('admin.dashboard', compact('users_count'));
	}

	public function password()
	{
	    return view('admin.password');
	}

	public function passwordUpdate(Request $request)
	{
	    $request->validate([
	        'old_password'  =>  'required',
	        'new_password'  =>  'required|confirmed'
	    ]);

	    if (\Hash::check($request->input('old_password'), Auth::user()->password)) {
	        Auth::user()->update(['password' => \Hash::make($request->input('new_password'))]);
	        return redirect()->back()
	                        ->withSuccess('UPDATED !! Your password is successfully updated');

	    }else{
	        return redirect()->back()->withErrors('ERROR !! Old password is not correct');
	    }
	}

}