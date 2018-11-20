<?php

namespace App\Http\Controllers\Api\Coach;

use App\Model\Programs;
use App\Model\Training;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class ProfileController extends Controller
{
    public function index()
    {

        $user = auth('api')->user();

        return $user = User::with(['profile','sports','Roles'])->where('id',$user->id)->first();

        return $user;

    }

    public function team($user_id) {

//        $user = auth('api')->user();
//
//        if($program_id == null) {
//
//            $co_workers = [];
//            $co_workers_id = $user->team;
//            foreach ($co_workers_id as $item) {
//
//                $user = User::with('profile')->find($item);
//                array_push($co_workers,$user);
//
//            }
//            return $co_workers;
//
//        } else {
//
//            $response_json = [];
//
//            $program = Programs::find($program_id);
//            $response_json['nutrition_doctor'] = $program->nutrition_doctor->profile;
//            $response_json['corrective_doctor'] = $program->corrective_doctor->profile;
//
//            return $response_json;
//
//
//        }

        $programs = Programs::with([
            'nutrition_doctor.profile',
            'nutrition_doctor.roles',
            'corrective_doctor.profile',
            'corrective_doctor.roles',
            'coach.profile',
            'coach.roles',
            'user.profile',
            'user.roles',
        ])->where('user_id',$user_id)->get();

        $co_workers = [];

        foreach ($programs as $program)
        {

            array_push($co_workers,$program->nutrition_doctor);
            array_push($co_workers,$program->corrective_doctor);
            array_push($co_workers,$program->coach);
//            array_push($co_workers,$program->nutrition_doctor);

        }

        return $co_workers;

    }

    public function addtoBasket(Request $request) {

        $data = $request->all();
        $user = auth('api')->user();
        $user->basket()->attach($data['training_id']);

        return response()->json([
            'message' => 'added'
        ],200);

    }

    public function basket()
    {

        $coach = auth('api')->user();
        $user = User::with('basket.sport')->find($coach->id);
        return $user->basket;


    }

    public function uploadImage(Request $request) {

        $coach = auth('api')->user();

        $validator = Validator::make($request->all(), [
            'photo' => 'required|image'
        ]);

        $ext = $request->photo->getClientOriginalExtension();
        $path = $request->photo->storeAs('/', $coach->id.'-'.md5(microtime()).'.'.$ext, 'photos');
        $url = 'storage/photos/'.$path;

        $profile = $coach->profile;
        $photos = $profile->photos;
        array_push($photos,$url);

        $profile->photos = $photos;
        $profile->save();

        return response()->json([
            'message' => 'آلبوم عکس شما به روز شد.'
        ],200);

    }
}
