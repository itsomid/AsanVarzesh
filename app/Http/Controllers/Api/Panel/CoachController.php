<?php

namespace App\Http\Controllers\Api\Panel;

use App\Helpers\Helper;
use App\Model\Profiles;
use App\Model\Programs;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CoachController extends Controller
{

    public function index()
    {


        $user_role = \App\Model\Role::find(3);
        $coaches = $user_role->users()->with(['profile','programs_by_coach'])->orderby('id','DESC')->get();

        return response()->json($coaches,200);

    }

    public function store(Request $request)
    {

        $data = $request->all();
        $helper = new Helper();
        $data['mobile'] = $helper->convert($data['mobile']);
        $messsages = array(
            'mobile.required'=>'پرکردن فیلد موبایل الزامی ست',
            'mobile.unique' => 'تلفن همراه تکراریست',
            'email.required'=>'فیلد ایمیل را پر کنید',
            'email.unique'=> 'ایمیل تکراریست',
            'first_name.required'=>'پرکردن فیلد نام الزامی ست',
            'last_name.required'=>'پرکردن فیلد نام خانوادگی الزامی ست',
            'city.required'=>'شهر را انتخاب کنید',
            'price.required' => 'قیمت را وارد کنید'
            //'avatar.required'=>'آواتار را انتخاب کنید',
        );
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|numeric|unique:users',
            'email' => 'required|unique:users',
            'first_name' => 'required',
            'last_name' => 'required',
            'city' => 'required',
            'price' => 'required'
            //'avatar' => 'mimes:jpeg,jpg,png,gif|required'
        ],$messsages);

        if ($validator->fails()) {

            return response()->json(['message' => $validator->errors()->first()],406);

        }



        $user = new User();
        $user->mobile = $data['mobile'];
        $user->password = bcrypt($data['mobile']);
        $user->email = $data['email'];
        $user->code = 0;
        $user->team = ['nutrition_doctor' => $data['nutrition_doctor'],'corrective_doctor' => $data['corrective_doctor']];
        $user->save();

        $user->roles()->attach(3,['sport_id' => $data['sport']]);
        $user->Coaches()->attach($data['sport'],['price' => $data['price']]);

        if(array_key_exists('avatar',$data) AND !is_null($data['avatar']) && $data['avatar'] != '') {
            $ext = $request->avatar->getClientOriginalExtension();
            $path = $request->avatar->storeAs('/', $user->id.'.'.$ext, 'avatars');
            $avatar_url = 'storage/avatars/'.$path;
        } else {
            $avatar_url = '';
        }


        $profile = new Profiles();
        $profile->avatar = $avatar_url;
        $profile->user_id = $user->id;
        $profile->first_name = $data['first_name'];
        $profile->last_name = $data['last_name'];
        $profile->city_id = $data['city'];
        $profile->address = $data['address'];
        $profile->birth_date = $data['birth_date'];
        $profile->coach_rate = $data['coach_rate'];
        $profile->covered_area = $data['covered_area'];
        $profile->education = $data['education'];
        $profile->education_title = $data['education_title'];
        $profile->experiences = $data['experiences'];
        $profile->expertise = $data['expertise'];
        $profile->gender = $data['gender'];
        $profile->height = $data['height'];
        $profile->national_code = $data['national_code'];
        $profile->weight = $data['weight'];
        $profile->save();




        return response()->json(['message' => 'مربی مورد نظر اضافه شد'],200);

    }

    public function update(Request $request, $user_id)
    {

        $data = $request->all();
        $helper = new Helper();
        $data['mobile'] = $helper->convert($data['mobile']);
        $messsages = array(
            'profile.first_name.required'=>'پرکردن فیلد نام الزامی ست',
            'profile.last_name.required'=>'پرکردن فیلد نام خانوادگی الزامی ست',
            'profile.new_avatar.mimes'=>'فرمت آواتار درست نیست',
        );
        $validator = Validator::make($request->all(), [
            //'mobile' => 'required|numeric|unique:users',
            'profile.first_name' => 'required',
            'profile.last_name' => 'required',
            'profile.new_avatar' => 'mimes:jpeg,jpg,png,gif'
        ],$messsages);

        if ($validator->fails()) {

            return response()->json(['message' => $validator->errors()->first()],406);

        }

        $user = User::findorFail($user_id);
        $user->mobile = $data['mobile'];
        $user->save();

        $user->profile->first_name = $data['profile']['first_name'];
        $user->profile->last_name = $data['profile']['last_name'];
        $user->profile->birth_date = $data['profile']['birth_date'];
        $user->profile->height = (float) $data['profile']['height'];
        $user->profile->city_id = $data['profile']['city_id'];
        $user->profile->weight = $data['profile']['weight'];
        $user->profile->appetite = $data['profile']['appetite'];
        $user->profile->blood_type = $data['profile']['blood_type'];
        $user->profile->budget = $data['profile']['budget'];
        $user->profile->diseases = $data['profile']['diseases'];
        $user->profile->education = $data['profile']['education'];
        $user->profile->education_title = $data['profile']['education_title'];
        $user->profile->address = $data['profile']['address'];
        $user->profile->coach_rate = $data['profile']['coach_rate'];
        $user->profile->covered_area = $data['profile']['covered_area'];
        $user->profile->education = $data['profile']['education'];
        $user->profile->education_title = $data['profile']['education_title'];
        $user->profile->experiences = $data['profile']['experiences'];
        $user->profile->expertise = $data['profile']['expertise'];
        $user->profile->maim = $data['profile']['maim'];

        $user->profile->save();

        return response()->json(['message' => 'پروفایل کاربر ویرایش شد'],200);

    }

    public function show($coach_id)
    {

        $user = User::with([
            'conversations.program.user.profile',
            'conversations.program.coach.profile',
            'conversations.program.sport',
            'conversations.user.profile',
            'profile',
            'programs_by_coach.sport',
            'programs_by_coach.user.profile',
            'programs_by_coach.coach.profile',
            'programs_by_coach.corrective_doctor.profile',
            'programs_by_coach.nutrition_doctor.profile',
            'payments_by_coach.program.sport'

        ])->where('id',$coach_id)->first();
        return response()->json($user,200);

    }

    public function payments($coach_id)
    {

        $user = User::where('id',$coach_id)->first();
        return response()->json($user->payments_by_coach,200);

    }

    public function sports($coach_id)
    {

        $user = User::where('id',$coach_id)->first();
        return response()->json($user->sports,200);

    }

    public function athletes($coach_id)
    {
        $programs = Programs::with('user.profile','sport')->where('coach_id',$coach_id)->orderby('id','DESC')->get();
        return $programs;
    }

    public function programs($coach_id,$status = null)
    {
        if($status == null) {
            $programs = Programs::with('user.profile','sport')->where('coach_id',$coach_id)->orderby('id','DESC')->get();
        } else {
            $programs = Programs::with('user.profile','sport')->where('status',$status)->where('coach_id',$coach_id)->orderby('id','DESC')->get();
        }

        return $programs;
    }

    public function uploadPhoto(Request $request,$user_id) {

        $user = User::find($user_id);

        $validator = Validator::make($request->all(), [
            'photo' => 'required|image'
        ]);

        $ext = $request->photo->getClientOriginalExtension();
        $path = $request->photo->storeAs('/', $user->id.'-'.md5(microtime()).'.'.$ext, 'photos');
        $url = '/storage/photos/'.$path;

        $profile = $user->profile;
        $photos = $profile->photos;
        if($photos == null) {
            $photos = [];
        }
        array_push($photos,$url);

        $profile->photos = $photos;
        $profile->save();

        return response()->json([
            'message' => 'آلبوم عکس شما به روز شد.'
        ],200);

    }


}
