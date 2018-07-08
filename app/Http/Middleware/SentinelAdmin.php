<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class SentinelAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Sentinel::check()) {
            $user = Sentinel::getUser();
            $admin = Sentinel::findRoleByName('Admin');
            return $user;
            if ($user->inRole($admin)) {
                return redirect()->intended('admin/dashboard');
            }
        }
        return $next($request);
    }
}
