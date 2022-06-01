<?php

namespace App\View\Components\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\Component;
use Takshak\Adash\Models\Permission;

class Layout extends Component
{
    public function __construct()
    {
        $roleIds = Auth::user()->roles->pluck('id')->toArray();
        $permissions = Permission::query()
            ->whereHas('roles', function ($query) use ($roleIds) {
                $query->whereIn('roles.id', $roleIds);
            })
            ->get();

        foreach ($permissions as $permission) {
            Gate::define($permission->name, function ($user) {
                return true;
            });
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('layouts.admin');
    }
}
