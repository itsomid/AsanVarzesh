<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Helper;
use App\Model\Profiles;
use App\Model\Subscription;
use App\User;
use Carbon\Carbon;
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

    public function mobile(Request $request, Helper $helper) {

        $username = $helper->convert($request->username);

        $user = User::where('mobile',$username)->first();
        $type = "registered before";
        if(!$user) {

            $user = new User();
            $user->mobile = $username;
            $user->save();

            // Add Role to User
            $user->roles()->attach(2);
            $type = 'new user';

            // Add Profile
            $profile = new Profiles();
            $profile->user_id = $user->id;
            $profile->first_name = '';
            $profile->last_name = '';
            $profile->birth_date = '';
            $profile->blood_type = '+A';
            $profile->diseases = 0;
            $profile->maim = 0;
            $profile->city_id = 117;
            $profile->address = '';
            $profile->nutrition_info = '';
            $profile->gender = 'male';
            $profile->national_code = '';
            $profile->education = '';
            $profile->education_title = '';
            $profile->height = 0;
            $profile->weight = 0;
            $profile->photos = null;
            $profile->save();

        }


        if(!$this->checkRoles($user->roles)) {
            $user->roles()->attach(2);
            $type = 'new user';
//            return response()->json([
//                'message' => 'شما مجاز نیستید'
//            ],400);
        }

        $code = $this->generateLoginCode();
        $user->code = 123456;
        $user->save();

        $message = 'برای ورود به اپلیکیشن آسان ورزش کد را وارد کنید:';
        $message .= $code;
        $sendSMS = Helper::sendSMS($username,$message);


        return response()->json([
            'message' => 'کد ورود به شماره تلفن '.$username.' ارسال شد.',
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


    protected function checkRoles($roles) {
        $can = false;
        foreach ($roles as $role) {
            $roleName = $role->name;
            if($roleName == 'user') {
                $can = true;
            }
        }
        return $can;
    }
}
