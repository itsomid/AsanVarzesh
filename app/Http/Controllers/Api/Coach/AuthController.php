<?php

namespace App\Http\Controllers\Api\Coach;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','mobile']]);
    }

    public function mobile(Request $request) {

        $user = User::where('mobile',$request['username'])->first();
        $type = "registered before";
        if(!$user) {

            /*$user = new User();
            $user->mobile = $request->username;
            $user->save();

            // Add Role to User
            $user->roles()->attach(2);
            $type = 'new user';*/

            return response()->json(['status' => 404,'message' => 'این شماره موبایل یافت نشد'],404);

        }

        $code = $this->generateLoginCode();
        $user->code = $code;
        $user->save();

        return response()->json([
            'code' => $user->code,
            'message' => 'کد ورود به شماره تلفن '.$user->mobile.' ارسال شد.',
            'status' => 200,
            'type' => $type
        ],200);

    }


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $credentials = request(['username', 'password']);

        if(!is_numeric($credentials['username']))
        {
            $user = User::where('email',$credentials['username'])->where('password',$credentials['password'])->first();
        } else
        {
            $user = User::where('mobile',$credentials['username'])->where('code',$credentials['password'])->first();
        }

        if(!$user) {
            return response()->json(['status' => 404,'message' => 'یافت نشد!'],404);
        }

        if (! $token = auth('api')->login($user) /*->attempt($credentials)*/) {
            return response()->json(['status' => 401,'message' => 'Unauthorized'], 401);
        }

        $user->status = 'active';
        $user->code = null;
//        $user->last_login = '';
        $user->save();

        return $this->respondWithToken($token);

    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL()
        ]);
    }

    protected function generateLoginCode() {

        return mt_rand(10000,999999);

    }
}