<?php

namespace App\Http\Controllers\Api\Panel;

use App\Helpers\Helper;
use App\Model\Calendar;
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
        $helper = new Helper();
        $data['mobile'] = $helper->convert($data['mobile']);
        $messsages = array(
            'mobile.required'=>'پرکردن فیلد موبایل الزامی ست',
            'first_name.required'=>'پرکردن فیلد نام الزامی ست',
            'last_name.required'=>'پرکردن فیلد نام خانوادگی الزامی ست',
            'city.required'=>'شهر را انتخاب کنید',
            'avatar.mimes'=>'فرمت آواتار درست نیست',
        );
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|numeric|unique:users',
            'first_name' => 'required',
            'last_name' => 'required',
            'city' => 'required',
            'avatar' => 'mimes:jpeg,jpg,png,gif'
        ],$messsages);


        if ($validator->fails()) {

            return response()->json(['message' => $validator->errors()->first()],406);

        }

        $user = new User();
        $user->mobile = $helper->convert($data['mobile']);
        $user->status = 'active';
        $user->code = 0;
        $user->password = bcrypt($helper->convert($data['mobile']));

        $user->save();
        $user->roles()->attach(2);

        if(array_key_exists('avatar',$data) AND !is_null($data['avatar']) && $data['avatar'] != '') {
            $ext = $request->avatar->getClientOriginalExtension();
            $path = $request->avatar->storeAs('/', $user->id.'.'.$ext, 'avatars');
            $avatar_url = 'storage/avatars'.$path;
        } else {
            $avatar_url = '';
        }



        $profile = new Profiles();
        $profile->user_id = $user->id;
        $profile->first_name = $data['first_name'];
        $profile->last_name = $data['last_name'];
        $profile->avatar = $avatar_url;
        $profile->birth_date = $data['birth_date'];
        $profile->appetite = $data['appetite'];
        $profile->blood_type = $data['blood_type'];
        $profile->budget = $data['budget'];
        $profile->city_id = $data['city'];
        $profile->diseases = $data['diseases'];
        $profile->education = $data['education'];
        $profile->education_title = $data['education_title'];
        $profile->gender = $data['gender'];
        $profile->height = (float) $helper->convert($data['height']);
        $profile->maim = $data['maim'];
        $profile->military_services = $data['military_services'];
        $profile->national_code = $helper->convert($data['national_code']);
        $profile->save();

        return response()->json(['message' => 'کاربر جدید اضافه شد'],200);
    }

    public function update(Request $request, $user_id)
    {

        $data = $request->all();
        $helper = new Helper();
        $data['mobile'] = $helper->convert($data['mobile']);
        $user = User::findorFail($user_id);
        $user->mobile = $data['mobile'];
        $user->email = $data['email'];
        $user->save();


        if(array_key_exists('new_avatar',$data) AND !is_null($data['new_avatar']) && $data['new_avatar'] != '') {
            $ext = $request->new_avatar->getClientOriginalExtension();
            $path = $request->new_avatar->storeAs('/', $user->id.'.'.$ext, 'avatars');
            $avatar_url = 'storage/avatars_new'.$path;
        } else {
            $avatar_url = $request->avatar;
        }


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
        $user->profile->avatar = $avatar_url;
        $user->profile->education_title = $data['profile']['education_title'];
        $user->profile->maim = $data['profile']['maim'];

        $user->profile->save();

        return response()->json(['message' => 'پروفایل کاربر ویرایش شد'],200);

    }
}
