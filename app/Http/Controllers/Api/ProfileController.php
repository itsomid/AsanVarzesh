<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Model\Profiles;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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
        $profile->text = $data['text'];
        //$profile->avatar = $data['avatar'];
        //$profile->photos = $data['photos'];
        $profile->height = $data['height'];
        $profile->weight = $data['weight'];
        $profile->blood_type = $data['blood_type'];
        $profile->diseases = $data['diseases']; // Json
        $profile->maim = $data['maim']; // Json
        $profile->city_id = $data['city_id'];
        $profile->address = $data['address'];
        $profile->keywords =  implode(' - ',[$data['first_name'],$data['last_name'],$data['first_name'].' '.$data['last_name']]); // Add First Name & Last Name For Search
        $profile->gender = $data['gender'];
        $profile->birth_date = $data['birth_date'];
        $profile->daily_activity = $data['daily_activity'];
        //$profile->selected_days_hours = $data['selected_days_hours']; // Json
        $profile->place_for_sport = $data['place_for_sport'];
        $profile->level = $data['level'];

        // Physical Info
        if(!is_null($data['abdominal'])) {
            $profile->abdominal = $data['abdominal'];
        }

        if(!is_null($data['arm'])) {
            $profile->arm = $data['arm'];
        }

        if(!is_null($data['wrist'])) {
            $profile->wrist = $data['wrist'];
        }

        if(!is_null($profile->hip = $data['hip'])) {
            $profile->hip = $data['hip'];
        }

        $profile->target = $data['target'];
        $profile->location = [ $data['location'][0],$data['location'][1] ]; // Point

        // Nutrition Info
        if(!is_null($data['nutrition_info'])) {
            $profile->nutrition_info = $data['nutrition_info']; // Json
        }
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
        $profile->text = $data['text'];
        //$profile->avatar = $data['avatar'];
        //$profile->photos = $data['photos'];
        $profile->height = $data['height'];
        $profile->weight = $data['weight'];
        $profile->blood_type = $data['blood_type'];
        $profile->diseases = $data['diseases']; // Json
        $profile->maim = $data['maim']; // Json
        $profile->city_id = $data['city_id'];
        $profile->address = $data['address'];
        $profile->keywords =  implode(' - ',[$data['first_name'],$data['last_name'],$data['first_name'].' '.$data['last_name']]); // Add First Name & Last Name For Search
        $profile->gender = $data['gender'];
        $profile->birth_date = $data['birth_date'];
        $profile->daily_activity = $data['daily_activity'];
        $profile->selected_days_hours = $data['selected_days_hours']; // Json
        $profile->place_for_sport = $data['place_for_sport'];
        $profile->level = $data['level'];
        $profile->abdominal = $data['abdominal'];
        $profile->arm = $data['arm'];
        $profile->wrist = $data['wrist'];
        $profile->hip = $data['hip'];
        $profile->target = $data['target'];
        $profile->location = [ $data['location'][0],$data['location'][1] ]; // Point
        $profile->nutrition_info = $data['nutrition_info']; // Json
        $profile->save();

        $message = 'پروفایل برای این اکانت ساخته شد.';
        $status = 200;

        return response()->json([
            'profile' => $profile,
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
                'profile' => $profile,
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
