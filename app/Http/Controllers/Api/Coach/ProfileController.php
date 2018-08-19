<?php

namespace App\Http\Controllers\Api\Coach;

use App\Model\Programs;
use App\Model\Training;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {

        $user = auth('api')->user();

        $user = User::with(['profile','sports'])->where('id',$user->id)->first();

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
            $response_json['nutrition_doctor'] = $program->nutrition_dr->profile;
            $response_json['corrective_doctor'] = $program->corrective_dr->profile;

            return $response_json;


        }

    }

    public function basket()
    {

        $trainings = Training::with('sport')->get();

        return $trainings;

    }
}
