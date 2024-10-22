<?php

namespace App\Http\Middleware;

use App\Repositories\UserRepository;
use Closure;
use Illuminate\Http\Request;

class CheckPermission
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
        $user = (new UserRepository())->find(auth()->id());
        $myPermissions = $user->getPermissionNames()->toArray();
        $myRole = $user->getRoleNames()->toArray()[0];

        $requestRoute = \request()->route()->getName();

        if(in_array($requestRoute, $myPermissions) || $myRole === 'root'){
            return $next($request);
        }

        return back()->with('error', 'Sorry, You have no permission');
    }
}
