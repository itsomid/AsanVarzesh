<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class CheckAuth extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        //return dd(response()->json(auth()->user()));
        $token = $this->auth->setRequest($request)->getToken();
        if (!$token = $this->auth->setRequest($request)->getToken()) {
            return $this->respond('tymon.jwt.absent', 'token_not_provided', 400);
        }

        try {
            $user = $this->auth->authenticate($token);
            if($user->status == 'inactive') {
                return response()->json([
                    'status' => 'Please Active Account',
                    'status' => 406,

                ],406);
            } else {

            }
        } catch (TokenExpiredException $e) {
            return abort(401);
        } catch (JWTException $e) {
            return abort(401);
        }

        if (!$user) {
            return $this->respond('tymon.jwt.user_not_found', 'user_not_found', 401);
        }


        return $next($request);
    }

}