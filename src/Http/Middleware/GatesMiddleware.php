<?php

namespace Takshak\Adash\Http\Middleware;

use App\Models\Permission;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
        $permissions = Permission::whereHas('roles', function($query) use($roleIds){
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