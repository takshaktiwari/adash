<?php

namespace Takshak\Adash\Traits\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Takshak\Imager\Facades\Imager;

trait AdminTrait
{
    public function index($value = '')
    {
        $users_count  = User::count();
        return view('admin.dashboard', compact('users_count'));
    }

    public function profileEdit()
    {
        return view('admin.profile_edit');
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name'      =>  'required',
            'email'     =>  'required|email|unique:users,email,' . auth()->id(),
            'mobile'    =>  'required',
            'password'  =>  'nullable|min:6',
        ]);

        $user = auth()->user();
        $user->name          =  $request->post('name');
        $user->mobile        =  $request->post('mobile');

        if ($user->email != $request->post('email')) {
            $user->email_verified_at = null;
        }
        if ($request->post('password')) {
            $user->password = Hash::make($request->post('password'));
        }
        if ($request->file('profile_img')) {
            $user->profile_img = 'users/' . time() . '.jpg';
            Imager::init($request->file('profile_img'))
                ->resizeFit(400, 400)->inCanvas('#fff')
                ->basePath(storage_path('app/public/'))
                ->save($user->profile_img);
        }
        $user->email =  $request->post('email');
        $user->save();

        return to_route('admin.profile.edit')->withSuccess('SUCCESS !! Your profile is successfully updated');
    }
}
