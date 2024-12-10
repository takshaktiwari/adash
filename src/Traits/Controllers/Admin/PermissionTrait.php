<?php

namespace Takshak\Adash\Traits\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Takshak\Adash\Models\Permission;
use Takshak\Adash\Models\Role;

trait PermissionTrait
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $this->authorize('permissions_access');
        $permissions = Permission::parent()->with('children')->orderBy('name')->get();
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        $this->authorize('permissions_create');
        $permissions = Permission::select('id', 'name', 'title')->parent()->orderBy('name')->get();
        return view('admin.permissions.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $this->authorize('permissions_create');
        $request->validate([
            'permission_id'    =>  'nullable|numeric',
            'name'      =>  'required|unique:permissions,name',
            'title'     =>  'required',
        ]);

        Permission::create([
            'permission_id'    =>  $request->post('permission_id'),
            'name'    =>  $request->post('name'),
            'title'    =>  $request->post('title'),
            'hint'    =>  $request->post('hint'),
        ]);

        return to_route('admin.permissions.index')->withSuccess('SUCCESS !! New Permission is successfully created');
    }

    public function edit(Permission $permission)
    {
        $this->authorize('permissions_update');
        $permissions = Permission::select('id', 'name', 'title')->parent()->orderBy('name')->get();
        return view('admin.permissions.edit', compact('permission', 'permissions'));
    }

    public function update(Request $request, Permission $permission)
    {
        $this->authorize('permissions_update');
        $request->validate([
            'permission_id'    =>  'nullable|numeric',
            'name'      =>  'required|unique:permissions,name,' . $permission->id,
            'title'     =>  'required',
        ]);

        $permission->update([
            'permission_id'    =>  $request->post('permission_id'),
            'name'    =>  $request->post('name'),
            'title'    =>  $request->post('title'),
            'hint'    =>  $request->post('hint'),
        ]);

        return to_route('admin.permissions.index')->withSuccess('SUCCESS !! New Permission is successfully updated');
    }

    public function destroy(Permission $permission)
    {
        $this->authorize('permissions_delete');
        $permission->delete();
        return to_route('admin.permissions.index')->withSuccess('SUCCESS !! Permission is successfully deleted');
    }

    public function rolePermissions()
    {
        $this->authorize('permissions_roles_update');
        $roles = Role::with('permissions')
            ->whereNotIn('name', ['admin'])
            ->orderBy('name')->get();
        $permissions = Permission::with('children')
            ->whereNull('permission_id')
            ->orderBy('name')->get();
        return view('admin.users.permission')->with('roles', $roles)
            ->with('permissions', $permissions);
    }

    public function rolePermissionsUpdate(Request $request, Role $role)
    {
        $this->authorize('permissions_roles_update');
        $request->validate([
            'permissions'   =>  'required|array'
        ]);

        $role->permissions()->sync($request->post('permissions'));
        return to_route('admin.permissions.index')->withSuccess('SUCCESS !! Permissions are successfully updated');
    }
}
