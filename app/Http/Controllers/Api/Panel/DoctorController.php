<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Profiles;
use App\Model\Programs;
use App\User;
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

        $user = new User();
        $user->mobile = $data['mobile'];
        $user->password = bcrypt($data['mobile']);
        $user->email = $data['email'];
        $user->code = 0;
        $user->save();
        $user->roles()->attach($data['dr_role_id']);

        $profile = new Profiles();
        $profile->user_id = $user->id;
        $profile->first_name = $data['first_name'];
        $profile->last_name = $data['last_name'];
        $profile->expertise = $data['expertise'];
        $profile->coach_rate = $data['coach_rate'];
        $profile->covered_area = $data['covered_area'];
        $profile->address = $data['address'];
        $profile->city_id = $data['city_id'];
        $profile->keywords = $data['keywords'];
        $profile->birth_date = $data['birth_date'];
        $profile->national_code = $data['national_code'];
        $profile->education = $data['education'];
        $profile->education_title = $data['education_title'];
        $profile->experiences = $data['experiences'];
        $profile->location = $data['location'];
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
        $user = User::with(['profile',$relation.'.sport',$relation.'.user.profile'])->where('id',$coach_id)->first()->toArray();

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
