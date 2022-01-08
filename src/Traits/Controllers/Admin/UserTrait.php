<?php

namespace Takshak\Adash\Traits\Controllers\Admin;

use Auth;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

trait UserTrait {

	public function index(Request $request)
	{
		$this->authorize('user_access');
	    $query = User::with('roles');
	    if ($request->get('search')) {
	        $query->where(function($query) use($request){
	            $query->where('name', 'like', '%'.$request->get('search').'%');
	            $query->orWhere('email', 'like', '%'.$request->get('search').'%');
	            $query->orWhere('mobile', 'like', '%'.$request->get('search').'%');
	        });
	    }
	    if ($request->get('role_id')){
	        $query->whereHas('roles', function($query){
	            $query->where('roles.id', request()->get('role_id'));
	        });
	    }
	    $users = $query->paginate(25)->withQueryString();
	    $roles = Role::orderBy('name', 'DESC')->get();
	    return view('admin.users.index')->with('users', $users)->with('roles', $roles);
	}

	public function create()
	{
		$this->authorize('user_create');
	    $roles = Role::orderBy('name', 'DESC')->get();
	    return view('admin.users.create')->with('roles', $roles);
	}

	public function store(Request $request)
	{
		$this->authorize('user_create');
	    $request->validate([
	        'name'      =>  'required',
	        'email'     =>  'required|email|unique:users,email',
	        'mobile'    =>  'required',
	        'password'  =>  'required|confirmed',
	        'roles'     =>  'required|array|min:1',
	        'email_verified'    =>  'required|boolean'
	    ]);

	    $user = User::create([
	        'name'          =>  $request->post('name'),
	        'email'         =>  $request->post('email'),
	        'mobile'        =>  $request->post('mobile'),
	        'password'      =>  \Hash::make($request->post('password')),
	        'email_verified_at'  =>  $request->post('email_verified') ? date('Y-m-d H:i:s') : null,
	    ]);

	    $user->roles()->sync($request->post('roles'));
	    return redirect()->route('admin.users.index')->withSuccess('SUCCESS !! New user is successfully created');
	}

	public function edit(User $user)
	{
		$this->authorize('user_update');
	    $roles = Role::orderBy('name', 'DESC')->get();
	    return view('admin.users.edit')->with('roles', $roles)->with('user', $user);
	}

	public function update(Request $request, User $user)
	{
		$this->authorize('user_update');
	    $request->validate([
	        'name'      =>  'required',
	        'email'     =>  'required|email|unique:users,email,'.$user->id,
	        'mobile'    =>  'required',
	        'roles'      =>  'required|array|min:1',
	        'email_verified'    =>  'required|boolean'
	    ]);

	    $user->name          =  $request->post('name');
	    $user->email         =  $request->post('email');
	    $user->mobile        =  $request->post('mobile');
	    $user->email_verified_at  =  $request->post('email_verified') 
	                                        ? date('Y-m-d H:i:s') 
	                                        : null;

	    $user->password = \Hash::make($request->post('password'));
	    $user->save();

	    $user->roles()->sync($request->post('roles'));

	    return redirect()->route('admin.users.index')->withSuccess('SUCCESS !! User is successfully updated');
	}

	public function show(User $user)
	{
		$this->authorize('user_show');
	    return view('admin.users.show')->with('user', $user);
	}

	public function loginToUser(User $user)
	{
		$this->authorize('login_to_user');
	    Auth::login($user);
	    return redirect()->route('root')->withSuccess("You are now logged in as $user->name. You have the full access of this user.");
	}

	public function destroy(User $user)
	{
		$this->authorize('user_delete');
	    $user->delete();
	    return redirect()->route('admin.users.index')->withErrors('SORRY !! Something is not right. Unable to delete user');
	}

}