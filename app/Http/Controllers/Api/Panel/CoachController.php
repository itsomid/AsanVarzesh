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
        $user->save();

        foreach ($data['sport_ids'] as $sport_id) {

            $user->roles()->attach(3,['sport_id' => $sport_id]);
        }

        $user->coaches()->attach(1,['price' => $data['price']]);

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




        return response()->json(['message' => 'مربی مورد نظر اضافه شد'],200);

    }

    public function show($coach_id)
    {

        $user = User::with(['profile','programs_by_coach'])->where('id',$coach_id)->first();
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
