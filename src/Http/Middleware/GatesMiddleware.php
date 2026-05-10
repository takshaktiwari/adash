<?php

namespace Takshak\Adash\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Takshak\Adash\Models\Permission;

class GatesMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $roleIds = Auth::user()->roles->pluck('id')->toArray();
        $permissions = Permission::query()
            ->whereHas('roles', function ($query) use ($roleIds) {
                $query->whereIn('roles.id', $roleIds);
            })
            ->get();

        foreach ($permissions as $permission) {
            Gate::define($permission->name, fn() => true);
        }

        return $next($request);
    }
}
