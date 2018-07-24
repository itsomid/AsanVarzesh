<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Model\Profiles;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Validator;


class ProfileController extends Controller
{
    //

    public function index() {

        $user = auth('api')->user();
        if(!$user->profile) {
            return response()->json([
                'status' => 404,
                'message' => 'پروفایلی برای این اکانت وجود ندارد'
                ],
                404);
        }
        return response()->json($user->profile,200);

    }

    public function update(Request $request) {

        $data = $request->all();
        $user = auth('api')->user();

        $profile = Profiles::where('user_id',$user->id)->first();
        if(!$profile) {

            return response()->json([
                    'status' => 404,
                    'message' => 'پروفایلی برای اکانت شما وجود ندارد'
                ]
                ,404);

        }

        $profile->user_id = $user->id;
        $profile->first_name = $data['first_name'];
        $profile->last_name = $data['last_name'];
        $profile->height = $data['height'];
        $profile->weight = $data['weight'];
        $profile->blood_type = $data['blood_type'];
        $profile->diseases = $data['diseases'];
        $profile->maim = $data['maim'];
        $profile->city_id = $data['city_id'];
        $profile->address = $data['address'];
        $profile->lat = $data['lat'];
        $profile->lng = $data['lng'];
        $profile->save();

        return response()->json([
            'status' => 200,
            'message' => 'پروفایل شما بروز شد'
        ]
        ,200);

    }

    public function store(Request $request) {
        $data = $request->all();
        $user = auth('api')->user();

        $profile = Profiles::where('user_id',$user->id)->first();
        $message = 'پروفایل برای اکانت شما قبلا ساخته شده است.';
        $status = 301;

        if($profile) {

            return response()->json([
                    'status' => 301,
                    'message' => 'پروفایل قبلا برای اکانت شما ساخته شده است'
                ]
                ,301);

        }


        $profile = new Profiles();
        $profile->user_id = $user->id;
        $profile->first_name = $data['first_name'];
        $profile->last_name = $data['last_name'];
        $profile->height = $data['height'];
        $profile->weight = $data['weight'];
        $profile->blood_type = $data['blood_type'];
        $profile->diseases = $data['diseases'];
        $profile->maim = $data['maim'];
        $profile->city_id = $data['city_id'];
        $profile->address = $data['address'];
        $profile->lat = $data['lat'];
        $profile->lng = $data['lng'];
        $profile->save();

        $message = 'پروفایل برای این اکانت ساخته شد.';
        $status = 200;

        return response()->json([
            'profile' => [
                'first_name' => $profile->first_name,
                'last_name' => $profile->last_name,
                'height' => $profile->height,
                'weight' => $profile->weight,
                'blood_type' => $profile->blood_type,
                'diseases' => $profile->diseases,
                'maim' => $profile->maim,
                'city_id' => $profile->city_id,
                'address' => $profile->address,
                'lat' => $profile->lat,
                'lng' => $profile->lng
            ],
            'status' => $status,
            'message' => $message
        ],200);

    }

    public function setAvatar(Request $request) {
        $data = $request->all();
        $user = auth('api')->user();

        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image'
        ]);

        if (!$validator->fails()) {

            $ext = $request->avatar->getClientOriginalExtension();
            $path = $request->avatar->storeAs('/', $user->id.'.'.$ext, 'avatars');
            $url = 'storage/avatars'.$path;

            $profile = Profiles::where('user_id',$user->id)->first();
            $profile->avatar = $url;
            $profile->save();

            return response()->json([
                'avatar_url' => url('storage/avatars/'.$path),
                'status' => 200
            ],200);

        } else {
            return response()->json([
                'msg' => 'فرمت فایل مورد نظر معتبر نیست.',
                'status' => 400
            ],400 );
        }

    }

    public function saveStep(Request $request) {

        $data = $request->all();

        $user = auth('api')->user();
        $user->steps = 'physical_info';
        $user->save();

        return response()->json(['status' => 200,'message' => 'Successful'],200);

    }

    public function getStep() {

        $user = auth('api')->user();

        return response()->json(['step' => $user->steps],200);

    }


}
