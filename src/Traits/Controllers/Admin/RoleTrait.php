<?php

namespace Takshak\Adash\Traits\Controllers\Admin;

use App\Models\Role;
use Illuminate\Http\Request;

trait RoleTrait {

	public function index()
	{
		$this->authorize('roles_access');
	    $roles = Role::orderBy('name')->get();
	    return view('admin.roles.index', compact('roles'));
	}

	public function create()
	{
		$this->authorize('roles_create');
	    return view('admin.roles.create');
	}

	public function store(Request $request)
	{
		$this->authorize('roles_create');
	    $request->validate([
	        'name'  =>  'required|unique:roles,name'
	    ]);

	    Role::create(['name' => $request->post('name') ]);
	    return redirect()->route('admin.roles.index')->withSuccess('SUCCESS !! New role has been added');
	}

	public function edit(Role $role)
	{
		$this->authorize('roles_update');
	    return view('admin.roles.edit', compact('role'));
	}

	public function update(Request $request, Role $role)
	{
		$this->authorize('roles_update');
	    $request->validate([
	        'name'  =>  'required|unique:roles,name,'.$role->id
	    ]);

	    $role->update(['name' => $request->post('name') ]);
	    return redirect()->route('admin.roles.index')->withSuccess('SUCCESS !! Role has been successfully updated');
	}

	public function destroy(Role $role)
	{
		$this->authorize('roles_delete');
	    $role->delete();
	    return redirect()->route('admin.roles.index')->withSuccess('SUCCESS !! Role has been successfully deleted');
	}
	
}