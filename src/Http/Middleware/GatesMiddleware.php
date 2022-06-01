<?php

namespace Takshak\Adash\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Takshak\Adash\Models\Permission;

class GatesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
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

        return $next($request);
    }
}
