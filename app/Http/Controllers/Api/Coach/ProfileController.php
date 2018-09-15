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

        return $user = User::with(['profile','sports'])->where('id',$user->id)->first();

        return $user;

    }

    public function team($program_id = null) {

        $user = auth('api')->user();

        if($program_id == null) {

            $co_workers = [];
            $co_workers_id = $user->team;
            foreach ($co_workers_id as $item) {

                $user = User::with('profile')->find($item);
                array_push($co_workers,$user);

            }
            return $co_workers;

        } else {

            $response_json = [];

            $program = Programs::find($program_id);
            $response_json['nutrition_doctor'] = $program->nutrition_doctor->profile;
            $response_json['corrective_doctor'] = $program->corrective_doctor->profile;

            return $response_json;


        }

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

    }
}
