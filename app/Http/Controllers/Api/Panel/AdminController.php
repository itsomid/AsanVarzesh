<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Profiles;
use App\Model\Programs;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{

    public function index()
    {

        $user_role = \App\Model\Role::find(6);
        $admins = $user_role->users()->with(['profile'])->orderby('id','DESC')->get();
        return response()->json($admins,200);

    }

    public function store(Request $request)
    {

        $data = $request->all();

        $messsages = array(

            'email.required'=>'پرکردن فیلد ایمیل الزامی ست',
            'email.unique'=>'ایمیل وارد شده تکراری ست',
            'email.email'=>'ایمیل را به درستی وارد کنید',
            'password.required'=>'فیلد رمزعبور را وارد کنید',
            'mobile.required'=>'پرکردن فیلد موبایل الزامی ست',
            'first_name.required'=>'پرکردن فیلد نام الزامی ست',
            'last_name.required'=>'پرکردن فیلد نام خانوادگی الزامی ست',
            'avatar.required'=>'آواتار را انتخاب کنید',

        );
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'mobile' => 'required|numeric|unique:users',
            'first_name' => 'required',
            'last_name' => 'required',
            'avatar' => 'mimes:jpeg,jpg,png,gif|required'
        ],$messsages);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()],406);
        }

        $user = new User();
        $user->mobile = $data['mobile'];
        $user->password = bcrypt($data['password']);
        $user->email = $data['email'];
        $user->code = 0;
        $user->save();

        $user->roles()->attach(6,['sport_id' => null]);

        $ext = $request->avatar->getClientOriginalExtension();
        $path = $request->avatar->storeAs('/', $user->id.'.'.$ext, 'avatars');
        $avatar_url = 'storage/avatars'.$path;

        $profile = new Profiles();
        $profile->avatar = $avatar_url;
        $profile->user_id = $user->id;
        $profile->first_name = $data['first_name'];
        $profile->last_name = $data['last_name'];
        $profile->city_id = $data['city'];
        $profile->address = $data['address'];
        $profile->gender = $data['gender'];
        $profile->save();




        return response()->json(['message' => 'مربی مورد نظر اضافه شد'],200);

    }

    public function update(Request $request, $user_id)
    {

        $data = $request->all();

        $messsages = array(
            'mobile.required'=>'پرکردن فیلد موبایل الزامی ست',
            'first_name.required'=>'پرکردن فیلد نام الزامی ست',
            'last_name.required'=>'پرکردن فیلد نام خانوادگی الزامی ست',
            'city_id.required'=>'شهر را انتخاب کنید',
            'avatar.required'=>'آواتار را انتخاب کنید',
        );
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|numeric|unique:users',
            'first_name' => 'required',
            'last_name' => 'required',
            'city_id' => 'required',
            'avatar' => 'mimes:jpeg,jpg,png,gif|required'
        ],$messsages);

        if ($validator->fails()) {

            return response()->json(['message' => $validator->errors()->first()],406);

        }

        $user = User::findorFail($user_id);

        $user->profile->first_name = $data['first_name'];
        $user->profile->last_name = $data['last_name'];
        $user->profile->birth_date = $data['birth_date'];
        $user->profile->height = (float) $data['height'];
        $user->profile->city_id = $data['city_id'];
        $user->profile->weight = $data['weight'];
        $user->profile->appetite = $data['appetite'];
        $user->profile->blood_type = $data['blood_type'];
        $user->profile->budget = $data['budget'];
        $user->profile->diseases = $data['diseases'];
        $user->profile->education = $data['education'];
        $user->profile->education_title = $data['education_title'];
        $user->profile->address = $data['address'];
        $user->profile->coach_rate = $data['coach_rate'];
        $user->profile->covered_area = $data['covered_area'];
        $user->profile->education = $data['education'];
        $user->profile->education_title = $data['education_title'];
        $user->profile->experiences = $data['experiences'];
        $user->profile->expertise = $data['expertise'];
        $user->profile->maim = $data['maim'];

        $user->profile->save();

        return response()->json(['message' => 'پروفایل کاربر ویرایش شد'],200);

    }

    public function show($coach_id)
    {

        $user = User::with([
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



}
