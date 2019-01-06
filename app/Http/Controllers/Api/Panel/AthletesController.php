<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Calendar;
use App\Model\Profiles;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

        $user = User::with([
            'profile',
            'nutrition_programs',
            'activities.calendar.training',
            'programs.calendar.training',
            'programs.sport',
            'programs.coach.profile',
            'programs.nutrition_doctor.profile',
            'programs.corrective_doctor.profile',
            'payments.program.sport',
            'payments.subscription'])->where('id',$user_id)->first();

        $user_arr = $user->toArray();
        $calendar = $user->nutrition_programs()->with('package','meal')->orderBy('id','DESC')->get()->groupBy('day_number')->toArray();
        $calendar_nutrition_transformed = [];
        foreach ($calendar as $key => $day) {
            $aDay['day_number'] = $key;
            $aDay['calendar_item'] = $day;
            array_push($calendar_nutrition_transformed,$aDay);
        }
        $user_arr['nutrition_programs'] = $calendar_nutrition_transformed;
        return response()->json($user_arr,200);

    }



    public function store(Request $request)
    {
        $data = $request->all();

        $messsages = array(
            'mobile.required'=>'پرکردن فیلد موبایل الزامی ست',
            'first_name.required'=>'پرکردن فیلد نام الزامی ست',
            'last_name.required'=>'پرکردن فیلد نام خانوادگی الزامی ست',
            'city.required'=>'شهر را انتخاب کنید',
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

        $user = new User();
        $user->mobile = $data['mobile'];
        $user->status = 'active';
        $user->code = 0;
        $user->password = bcrypt($data['mobile']);

        $user->save();
        $user->roles()->attach(2);

        $ext = $request->avatar->getClientOriginalExtension();
        $path = $request->avatar->storeAs('/', $user->id.'.'.$ext, 'avatars');
        $avatar_url = 'storage/avatars'.$path;

        $profile = new Profiles();
        $profile->user_id = $user->id;
        $profile->first_name = $data['first_name'];
        $profile->last_name = $data['last_name'];
        $profile->avatar = $avatar_url;
        $profile->height = $data['height'];
        $profile->birth_date = $data['birth_date'];
        $profile->appetite = $data['appetite'];
        $profile->blood_type = $data['blood_type'];
        $profile->budget = $data['budget'];
        $profile->city_id = $data['city'];
        $profile->diseases = $data['diseases'];
        $profile->education = $data['education'];
        $profile->education_title = $data['education_title'];
        $profile->gender = $data['gender'];
        $profile->height = (float) $data['height'];
        $profile->maim = $data['maim'];
        $profile->military_services = $data['military_services'];
        $profile->national_code = $data['national_code'];
        $profile->save();

        return response()->json(['message' => 'کاربر جدید اضافه شد'],200);
    }

    public function update(Request $request, $user_id)
    {

        $data = $request->all();

        $user = User::findorFail($user_id);
        ///$user->mobile = $data['mobile'];

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
        $user->profile->maim = $data['maim'];

        $user->profile->save();

        return response()->json(['message' => 'پروفایل کاربر ویرایش شد'],200);

    }
}
