<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\Helper;
use App\Model\Profiles;
use App\Model\Programs;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;


class ProfileController extends Controller
{
    //

    public function index($program_id = null)
    {

        $user = auth('api')->user();
        if (!$user->profile) {
            return response()->json([
                'status' => 404,
                'message' => 'پروفایلی برای این اکانت وجود ندارد'
            ],
                404);
        }

        $user = User::with([
            'profile.city',
            'programs.corrective_doctor',
            'programs.nutrition_doctor',
            'programs.coach',
            'programs.sport',
            'activities',
            'payments'
        ])->find($user->id);
        return response()->json($user, 200);

    }

    public function update(Request $request)
    {

        $data = $request->all();
        $user = auth('api')->user();

        $profile = Profiles::where('user_id', $user->id)->first();
        if (!$profile) {

            return response()->json([
                    'status' => 404,
                    'message' => 'پروفایلی برای اکانت شما وجود ندارد'
                ]
                , 404);

        }

        $profile->user_id = $user->id;
        $profile->first_name = $data['first_name'];
        $profile->last_name = $data['last_name'];
        $profile->blood_type = $data['blood_type'];
        $profile->diseases = $data['diseases'];
        $profile->maim = $data['maim'];
        $profile->city_id = $data['city_id'];
        $profile->address = $data['address'];
        $profile->nutrition_info = $data['nutrition_info'];
        $profile->gender = $data['gender'];

        $profile->height = $data['height'];
        $profile->weight = $data['weight'];
        $profile->abdominal = $data['abdominal'];
        $profile->arm = $data['arm'];
        $profile->wrist = $data['wrist'];
        $profile->hip = $data['hip'];
        $profile->waist = $data['waist'];
        $profile->foot_thighs = $data['foot_thighs'];
        $profile->ankle = $data['ankle'];
        $profile->chest = $data['chest'];
        $profile->shoulder = $data['shoulder'];
        $profile->forearm = $data['forearm'];

        $profile->birth_date = $data['birth_date'];
        $profile->education = $data['education'];
        $profile->education_title = $data['education_title'];
        $profile->national_code = $data['national_code'];
        $profile->nutrition_habits = $data['nutrition_habits'];
        $profile->location = [$data['location'][0], $data['location'][1]]; // Point
        $profile->save();

        $lastProgram = Programs::where('user_id')->orderby('id','DESC')->first();
        if($lastProgram) {
            $lastProgram->weight = $data['weight'];
            $lastProgram->abdominal = $data['abdominal'];
            $lastProgram->arm = $data['arm'];
            $lastProgram->wrist = $data['wrist'];
            $lastProgram->hip = $data['hip'];
            $lastProgram->waist = $data['waist'];
            $lastProgram->foot_thighs = $data['foot_thighs'];
            $lastProgram->ankle = $data['ankle'];
            $lastProgram->chest = $data['chest'];
            $lastProgram->shoulder = $data['shoulder'];
            $lastProgram->forearm = $data['forearm'];
            $lastProgram->save();
        }


        return response()->json([
                'profile' => $profile,
                'status' => 200,
                'message' => 'پروفایل شما بروز شد'
            ]
            , 200);

    }

    public function store(Request $request)
    {

        $data = $request->all();
        $user = auth('api')->user();
        $profile = Profiles::where('user_id', $user->id)->first();
        $message = 'پروفایل برای اکانت شما قبلا ساخته شده است.';
        $status = 301;

        if ($profile) {

            return response()->json([
                    'status' => 301,
                    'message' => 'پروفایل قبلا برای اکانت شما ساخته شده است'
                ]
                , 301);

        }



        $messsages = array(
            'first_name.required'=>'پرکردن فیلد نام الزامی ست',
            'last_name.required'=>'پرکردن فیلد نام خانوادگی الزامی ست',
            'city_id.required'=>'شهر را انتخاب کنید',
        );

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'city_id' => 'required',
        ];

        $validator = Validator::make($data, $rules, $messsages);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()],406);
        }


        $profile = new Profiles();
        $profile->user_id = $user->id;
        $profile->first_name = $data['first_name'];
        $profile->last_name = $data['last_name'];

        $profile->blood_type = $data['blood_type'];
        $profile->birth_date = $data['birth_date'];
        $profile->diseases = $data['diseases'];
        $profile->maim = $data['maim'];
        $profile->city_id = $data['city_id'];
        $profile->address = $data['address'];
        $profile->nutrition_info = $data['nutrition_info'];
        $profile->gender = $data['gender'];
        $profile->location = [$data['location'][0], $data['location'][1]]; // Point
        $profile->national_code = $data['national_code'];
        $profile->education = $data['education'];
        $profile->education_title = $data['education_title'];

        $profile->height = $data['height'];
        $profile->weight = $data['weight'];
        $profile->abdominal = $data['abdominal'];
        $profile->arm = $data['arm'];
        $profile->wrist = $data['wrist'];
        $profile->hip = $data['hip'];
        $profile->waist = $data['waist'];
        $profile->foot_thighs = $data['foot_thighs'];
        $profile->ankle = $data['ankle'];
        $profile->chest = $data['chest'];
        $profile->shoulder = $data['shoulder'];
        $profile->forearm = $data['forearm'];

        $profile->save();

        $user->steps = 'profile';

        $user->save();


        $message = 'پروفایل برای این اکانت ساخته شد.';
        $status = 200;


        return response()->json([
            'profile' => $profile,
            'status' => $status,
            'message' => $message
        ], 200);

    }

    public function setAvatar(Request $request)
    {
        $data = $request->all();
        $user = auth('api')->user();

        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image'
        ]);

        if (!$validator->fails()) {

            $ext = $request->avatar->getClientOriginalExtension();
            $path = $request->avatar->storeAs('/', $user->id . '.' . $ext, 'avatars');
            $url = 'storage/avatars/' . $path;

            $profile = Profiles::where('user_id', $user->id)->first();
            $profile->avatar = $url;
            $profile->save();

            return response()->json([
                'profile' => $profile,
                'avatar_url' => 'storage/avatars/' . $path,
                'status' => 200
            ], 200);

        } else {
            return response()->json([
                'msg' => 'فرمت فایل مورد نظر معتبر نیست.',
                'status' => 400
            ], 400);
        }

    }



    public function saveStep(Request $request)
    {

        $data = $request->all();

        $user = auth('api')->user();
        $user->steps = 'physical_info';
        $user->save();

        return response()->json(['status' => 200, 'message' => 'Successful'], 200);

    }

    public function getStep()
    {

        $user = auth('api')->user();

        return response()->json(['step' => $user->steps], 200);

    }


}
