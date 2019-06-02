<?php

namespace App\Http\Controllers\Api\Panel;

use App\Helpers\Helper;
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
        $doctors = $user_role->users()->with(['profile.city',$relation.'.sport',$relation.'.user.profile'])->orderby('id','DESC')->get();

        return response()->json($doctors,200);

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
            'experiences.required' => 'تجربیات را وارد کنید'
            //'avatar.required'=>'آواتار را انتخاب کنید',
        );
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|numeric|unique:users',
            'email' => 'required|unique:users',
            'first_name' => 'required',
            'last_name' => 'required',
            'city' => 'required',
            'experiences' => 'required'
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
        $profile->birth_date = $data['birth_date'];
        $profile->city_id = $data['city'];
        $profile->education = $data['education'];
        $profile->education_title = $data['education_title'];

        $profile->experiences = !isset($data['experiences']) ? '' : $data['experiences'];
        $profile->expertise = !isset($data['expertise']) ? '' : $data['expertise'];
        $profile->gender = !isset($data['gender']) ? 'male' : $data['gender'];
        $profile->height = !isset($data['height']) ? 0 : $data['height'];
        $profile->national_code = !isset($data['national_code']) ? 0 : $data['national_code'];
        $profile->weight = !isset($data['weight']) ? 0 : $data['weight'];
        $profile->photos = null;
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

        if($role_id == '4') {
            $relation_payment = 'payments_by_nutrition';
        } else {
            $relation_payment = 'payments_by_corrective';
        }

        $user = User::with([
            'conversations.program.user.profile.city',
            'conversations.program.coach.profile.city',
            'conversations.program.sport',
            'conversations.user.profile.city',
            'profile',$relation.'.sport',
            $relation.'.user.profile.city',
            $relation.'.coach.profile.city',
            $relation.'.corrective_doctor.profile.city',
            $relation.'.nutrition_doctor.profile.city',
            $relation_payment.'.program.sport'
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
        $programs = Programs::with('user.profile.city','sport')->where('corrective_doctor_id', $dr_id)->orWhere('nutrition_doctor_id',$dr_id)->orderby('id','DESC')->get();
        return $programs;
    }

    public function programs($coach_id,$status = null)
    {
        if($status == null) {
            $programs = Programs::with('user.profile.city','sport')->where('coach_id',$coach_id)->orderby('id','DESC')->get();
        } else {
            $programs = Programs::with('user.profile.city','sport')->where('status',$status)->where('coach_id',$coach_id)->orderby('id','DESC')->get();
        }

        return $programs;
    }

}
