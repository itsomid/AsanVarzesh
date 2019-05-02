<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class AdminRole
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

        $roles = auth('api')->user()->roles;
        foreach ($roles as $role) {

            if(!$role->name == 'admin') {
                return redirect('auth/login');
            }

        }
        return $next($request);
    }
}
