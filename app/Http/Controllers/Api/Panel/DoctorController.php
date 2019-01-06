<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Profiles;
use App\Model\Programs;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DoctorController extends Controller
{

    public function index($role_id)
    {

        if($role_id == '4') {
            $relation = 'programs_by_nutrition_doctor';
        } else {
            $relation = 'programs_by_corrective_doctor';
        }
        $user_role = \App\Model\Role::find($role_id);
        $doctors = $user_role->users()->with(['profile',$relation.'.sport',$relation.'.user.profile'])->orderby('id','DESC')->get();

        return response()->json($doctors,200);

    }

    public function store(Request $request)
    {

        $data = $request->all();

        $messsages = array(
            'mobile.required'=>'پرکردن فیلد موبایل الزامی ست',
            'first_name.required'=>'پرکردن فیلد نام الزامی ست',
            'last_name.required'=>'پرکردن فیلد نام خانوادگی الزامی ست',
            'city.required'=>'شهر را انتخاب کنید',
            //'avatar.required'=>'آواتار را انتخاب کنید',
        );
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|numeric|unique:users',
            'first_name' => 'required',
            'last_name' => 'required',
            'city' => 'required',
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
        $user->save();
        $user->roles()->attach($data['dr_role_id']);

        $ext = $request->avatar->getClientOriginalExtension();
        $path = $request->avatar->storeAs('/', $user->id.'.'.$ext, 'avatars');
        $avatar_url = 'storage/avatars'.$path;

        $profile = new Profiles();
        $profile->avatar = $avatar_url;
        $profile->user_id = $user->id;
        $profile->first_name = $data['first_name'];
        $profile->last_name = $data['last_name'];
        $profile->birth_date = $data['birth_date'];
        $profile->city_id = $data['city'];
        $profile->education = $data['education'];
        $profile->education_title = $data['education_title'];
        $profile->experiences = $data['experiences'];
        $profile->expertise = $data['expertise'];
        $profile->gender = $data['gender'];
        $profile->height = $data['height'];
        $profile->national_code = $data['national_code'];
        $profile->weight = $data['weight'];
        $profile->save();




        return response()->json(['message' => 'پزشک مورد نظر اضافه شد'],200);

    }

    public function show($role_id,$coach_id)
    {

        if($role_id == '4') {
            $relation = 'programs_by_nutrition_doctor';
        } else {
            $relation = 'programs_by_corrective_doctor';
        }
        $user = User::with([
            'profile',$relation.'.sport',
            $relation.'.user.profile',
            $relation.'.coach.profile',
            $relation.'.corrective_doctor.profile',
            $relation.'.nutrition_doctor.profile',
        ])->where('id',$coach_id)->first()->toArray();

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

    public function athletes($dr_id)
    {
        $programs = Programs::with('user.profile','sport')->where('corrective_doctor_id', $dr_id)->orWhere('nutrition_doctor_id',$dr_id)->orderby('id','DESC')->get();
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

}
