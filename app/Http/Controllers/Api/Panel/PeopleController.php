<?php

namespace App\Http\Controllers\Api\Panel;

use App\Helpers\Helper;
use App\Model\Profiles;
use App\Model\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PeopleController extends Controller
{

    public function index(Request $request) {
        $qs = $request;
        if(isset($qs['role_id'])) {
            $role_id = $qs['role_id'];
            $users = User::with('profile.city')->whereHas('roles', function ($query) use ($role_id) {
                $query->where('id', '=', $role_id);
            })->orderby('id','DESC')->paginate(5);
        } else {
            $users = User::with('profile.city')->orderby('id','DESC')->paginate(5);
        }

        return response()->json($users,200);

    }

    public function store(Request $request) {
        $helper = new Helper();
        $data = $request->all();

        $messsages = array(
            'user.email.unique' => 'ایمیل تکراریست',
            'user.mobile.required' => 'شماره موبایل را وارد کنید',
            'user.mobile.unique' => 'شماره موبایل تکراری ست',
            'user.corrective_doctor.required' => 'متخصص اصلاحی را انتخاب کنید',
            'user.nutrition_doctor.required' => 'متخصص اصلاحی را انتخاب کنید',
            'user.price.required' => 'قیمت را وارد کنید',
            'user.sport_id.required' => 'ورزش را انتخاب کنید',
            'profile.first_name.required'=>'پرکردن فیلد نام الزامی ست',
            'profile.last_name.required'=>'پرکردن فیلد نام خانوادگی الزامی ست',
            'profile.city_id.required'=>'شهر را انتخاب کنید',
            'profile.avatar.image' => 'فرمت آواتار درست نیست',

        );

        $rules = [
            'user.email' => 'nullable|unique:users,email',
            'user.mobile' => 'required|unique:users,mobile',
            'profile.first_name' => 'required',
            'profile.last_name' => 'required',
            'profile.city_id' => 'required',
        ];

        if($request->profile['avatar'] != null || $request->profile['avatar'] != '') {
            $rules['profile.avatar'] = 'image';
        }

        if($data['role_id'] == 3) {
            $rules['user.corrective_doctor'] = 'required';
            $rules['user.nutrition_doctor'] = 'required';
            $rules['user.price'] = 'required';
            $rules['user.sport_id'] = 'required';
        }

        $validator = Validator::make($request->all(), $rules, $messsages);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()],406);
        }


        $user = new User();
        $user->email = $data['user']['email'];
        $user->mobile = $helper->convert($data['user']['mobile']);
        $user->status = 'active';
        $user->code = 0;
        $user->password = bcrypt($helper->convert($data['user']['mobile']));
        $user->team = [
            'nutrition_doctor' => $data['user']['nutrition_doctor'],
            'corrective_doctor' => $data['user']['corrective_doctor']
        ];
        $user->save();
        $user->roles()->attach($data['role_id']);


        // Create Team
        if($data['role_id'] == 3) {
            $user->Coaches()->attach($data['user']['sport_id'],['price' => $data['user']['price']]);
        }

        if(array_key_exists('avatar',$data['profile']) AND !is_null($data['profile']['avatar']) && $data['profile']['avatar'] != '') {
            $ext = $request->profile['avatar']->getClientOriginalExtension();
            $path = $request->profile['avatar']->storeAs('/', $user->id.'.'.$ext, 'avatars');
            $avatar_url = 'storage/avatars/'.$path;
        } else {
            $avatar_url = '';
        }

        $profile = new Profiles();
        $profile->first_name = $data['profile']['first_name'];
        $profile->last_name = $data['profile']['last_name'];
        $profile->user_id = $user->id;
        $profile->gender = $data['profile']['gender'];
        $profile->city_id = $data['profile']['city_id'];
        $profile->address = $data['profile']['address'];
        $profile->military_services = $data['profile']['military_services'];
        $profile->national_code = $data['profile']['national_code'];
        $profile->birth_date = $data['profile']['birth_date'];
        $profile->blood_type = $data['profile']['blood_type'];
        $profile->education = $data['profile']['education'];
        $profile->education_title = $data['profile']['education_title'];
        $profile->diseases = $data['profile']['diseases'];
        $profile->maim = $data['profile']['maim'];
        $profile->nutrition_info = $data['profile']['nutrition_info'];
        $profile->appetite = $data['profile']['appetite'];
        $profile->covered_area = $data['profile']['covered_area'];
        $profile->coach_rate = $data['profile']['coach_rate'];
        $profile->height = (float) $data['profile']['height'];
        $profile->weight = (float) $data['profile']['weight'];
        $profile->expertise = $data['profile']['expertise'];
        $profile->avatar = $avatar_url;
        $profile->experiences = $data['profile']['experiences'];
        $profile->photos = [];
        $profile->save();

        return response()->json(['message' => 'کاربر جدید اضافه شد'],200);

    }

    public function show($user_id) {

        $user = User::find($user_id);

        $user = User::with([
            'sport',
            'Roles',
            'conversations.program.user.profile',
            'conversations.program.coach.profile',
            'conversations.program.sport',
            'conversations.user.profile',

            'profile.city.state',

            'programs_by_coach.sport',
            'programs_by_coach.user.profile',
            'programs_by_coach.coach.profile',
            'programs_by_coach.corrective_doctor.profile',
            'programs_by_coach.nutrition_doctor.profile',

            'programs_by_corrective_doctor.sport',
            'programs_by_corrective_doctor.user.profile',
            'programs_by_corrective_doctor.coach.profile',
            'programs_by_corrective_doctor.corrective_doctor.profile',
            'programs_by_corrective_doctor.nutrition_doctor.profile',

            'programs_by_nutrition_doctor.sport',
            'programs_by_nutrition_doctor.user.profile',
            'programs_by_nutrition_doctor.coach.profile',
            'programs_by_nutrition_doctor.corrective_doctor.profile',
            'programs_by_nutrition_doctor.nutrition_doctor.profile',

            'payments_by_coach.program.sport',
            'payments_by_corrective.program.sport',
            'payments_by_nutrition.program.sport',


        ])->where('id',$user_id)->first();
        return response()->json($user,200);
    }

    public function update(Request $request,$user_id) {

        $data = $request->all();

        $messsages = array(
            'user.email.unique' => 'ایمیل تکراریست',
            'user.mobile.required' => 'شماره موبایل را وارد کنید',
            'user.mobile.unique' => 'شماره موبایل تکراری ست',
            'user.corrective_doctor.required' => 'متخصص اصلاحی را انتخاب کنید',
            'user.nutrition_doctor.required' => 'متخصص اصلاحی را انتخاب کنید',
            'user.price.required' => 'قیمت را وارد کنید',
            'user.sport_id.required' => 'ورزش را انتخاب کنید',
            'profile.first_name.required'=>'پرکردن فیلد نام الزامی ست',
            'profile.last_name.required'=>'پرکردن فیلد نام خانوادگی الزامی ست',
            'profile.city_id.required'=>'شهر را انتخاب کنید',
            'profile.new_avatar.image' => 'فرمت آواتار درست نیست',

        );

        $rules = [
            'user.mobile' => 'required|unique:users,mobile,'.$user_id,
            'profile.first_name' => 'required',
            'profile.last_name' => 'required',
            'profile.city_id' => 'required',
        ];

        if(array_key_exists('email',$data['user']) && $data['user']['email'] != '') {
            $rules['user.email'] = 'unique:users,email,'.$user_id;
        }

        if(array_key_exists('new_avatar',$data['profile'])) {
            if($request->profile['new_avatar'] != null || $request->profile['new_avatar'] != '') {
                $rules['profile.new_avatar'] = 'image';
            }
        }

        if($data['role_id'] == 3) {
            $rules['user.corrective_doctor'] = 'required';
            $rules['user.nutrition_doctor'] = 'required';
            $rules['user.price'] = 'required';
            $rules['user.sport_id'] = 'required';
        }



        $validator = Validator::make($request->all(), $rules, $messsages);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()],406);
        }

        // Upload New Avatar
        if(array_key_exists('new_avatar',$data['profile']) AND !is_null($data['profile']['new_avatar']) && $data['profile']['new_avatar'] != '') {
            $ext = $request->profile['new_avatar']->getClientOriginalExtension();
            $path = $request->profile['new_avatar']->storeAs('/', $user_id.'.'.$ext, 'avatars');
            $avatar_url = 'storage/avatars/'.$path;
        } else {
            $avatar_url = $data['profile']['avatar'];
        }

        $user = User::find($user_id);
        if(array_key_exists('email',$data['user']) && $data['user']['email'] != '') {
            $user->user = $data['user']['email'];
        }
        $user->mobile = $data['user']['mobile'];
        $user->status = $data['user']['status'];
        $user->team = [
            'nutrition_doctor' => $data['user']['nutrition_doctor'],
            'corrective_doctor' => $data['user']['corrective_doctor']
        ];
        $user->save();

        // Sync Coach Team, Sport & Price
        if($data['role_id'] == 3) {

            $user->Coaches()->sync($data['user']['sport_id'],['price' => $data['user']['price']]);


        }

        $user->profile->first_name = $data['profile']['first_name'];
        $user->profile->last_name = $data['profile']['last_name'];
        $user->profile->user_id = $user->id;
        $user->profile->gender = $data['profile']['gender'];
        $user->profile->city_id = $data['profile']['city_id'];
        $user->profile->address = $data['profile']['address'];
        $user->profile->military_services = $data['profile']['military_services'];
        $user->profile->national_code = $data['profile']['national_code'];
        $user->profile->birth_date = $data['profile']['birth_date'];
        $user->profile->blood_type = $data['profile']['blood_type'];
        $user->profile->education = $data['profile']['education'];
        $user->profile->education_title = $data['profile']['education_title'];
        $user->profile->diseases = $data['profile']['diseases'];
        $user->profile->maim = $data['profile']['maim'];
        $user->profile->nutrition_info = $data['profile']['nutrition_info'];
        $user->profile->appetite = $data['profile']['appetite'];
        $user->profile->covered_area = $data['profile']['covered_area'];
        $user->profile->coach_rate = $data['profile']['coach_rate'];
        $user->profile->height = (float) $data['profile']['height'];
        $user->profile->weight = (float) $data['profile']['weight'];
        $user->profile->expertise = $data['profile']['expertise'];
        $user->profile->avatar = $avatar_url;
        $user->profile->experiences = $data['profile']['experiences'];
        //$user->profile->photos = [];
        $user->profile->save();

    }
}
