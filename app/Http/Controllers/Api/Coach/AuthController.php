<?php

namespace App\Http\Controllers\Api\Coach;

use App\Helpers\Helper;
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
            return response()->json(['status' => 404,'message' => 'این شماره موبایل یافت نشد'],404);
        }


//        foreach($user->roles as $role) {
//            $roleName = $role->name;
//            if($roleName != 'coach' OR $roleName != 'nutrition-doctor' OR $roleName != 'corrective-doctor') {
//                return response()->json([
//                    'message' => 'شما مجاز نیستید'
//                ],400);
//            }
//        }

        if(!$this->checkRoles($user->roles)) {
            return response()->json([
                'message' => 'شما مجاز نیستید'
            ],400);
        }

        $code = $this->generateLoginCode();
        $user->code = $code;
        $user->save();

        $message = 'برای ورود به اپلیکیشن آسان ورزش کد را وارد کنید:';
        $message .= $code;
        $sendSMS = Helper::sendSMS($user->mobile,$message);

        return response()->json([
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
        $user->code = $this->generateLoginCode();
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

    protected function checkRoles($roles) {
        $can = false;
        foreach ($roles as $role) {
            $roleName = $role->name;
            if($roleName == 'coach' OR $roleName == 'nutrition-doctor' OR $roleName == 'corrective-doctor') {
                $can = true;
            }
        }
        return $can;
    }
}
