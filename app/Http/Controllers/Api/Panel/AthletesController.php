<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Profiles;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class AthletesController extends Controller
{

    public function index()
    {

        $user_role = \App\Model\Role::find(2);
        $users = $user_role->users()->with(['programs.sport','profile'])->orderby('id','DESC')->get();

        return response()->json($users,200);

    }

    public function show($user_id)
    {

        $user = User::with(['activities','programs.calendar.training','programs.sport','profile'])->where('id',$user_id)->first();

        return response()->json($user,200);

    }

    public function store(Request $request)
    {
	
    }

    public function update(Request $request, $user_id)
    {

        $data = $request->all();

        $user = User::findorFail($user_id);
        $user->mobile = $data['mobile'];

        $user->profile->first_name = $data['first_name'];
        $user->profile->last_name = $data['last_name'];
        $user->profile->birth_date = $data['birth_date'];
        $user->profile->height = $data['height'];
        $user->profile->city_id = $data['city_id'];
        $user->profile->blood_type = $data['blood_type'];

        $user->profile->save();

        return response()->json(['message' => 'پروفایل کاربر ویرایش شد'],200);

    }
}
