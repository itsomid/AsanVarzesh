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



        $token = $this->auth->setRequest($request)->getToken();
        if (!$token = $this->auth->setRequest($request)->getToken()) {
            return response()->json([
                'message' => 'token is empty',
                'status' => 401,
            ],401);
            //return $this->respond('tymon.jwt.absent', 'token_not_provided', 400);
        }



        try {


            $user = $this->auth->authenticate($token);
            if($user == null) {
                return response()->json([
                    'message' => 'Not Found with this token',
                    'status' => 401,
                ],401);
            }
            if($user->status == 'inactive') {
                return response()->json([
                    'message' => 'Please Active Account',
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
