<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class SentinelUser
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
        $user = Sentinel::getUser();
        $users = Sentinel::findRoleByName('User');

        if (!$user->inRole($users)) {
            return redirect('auth/login');
        }
        return $next($request);
    }
}
