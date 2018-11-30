<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Profiles;
use App\Model\Programs;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        $user = new User();
        $user->mobile = $data['mobile'];
        $user->password = bcrypt($data['mobile']);
        $user->email = $data['email'];
        $user->code = 0;
        $user->team = ['nutrition_doctor' => $data['nutrition_doctor'],'corrective_doctor' => $data['corrective_doctor']];
        $user->save();

        $user->roles()->attach(3,['sport_id' => $data['sport']]);
        $user->Coaches()->attach($data['sport'],['price' => $data['price']]);

        $profile = new Profiles();
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

    public function show($coach_id)
    {

        $user = User::with(['profile','programs_by_coach.sport','programs_by_coach.user.profile'])->where('id',$coach_id)->first();
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

}
