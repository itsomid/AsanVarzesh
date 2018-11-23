<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Programs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RequestsController extends Controller
{
    public function index() {

        $requests = Programs::with(['sport','user.profile'])->where('status','pending')->get();
        return $requests;

    }

    public function show($program_id)
    {

        $request = Programs::with(['sport','user','coach','nutrition_doctor','corrective_doctor'])->where('id',$program_id)->first();
        return $request;

    }

    public function store(Request $request) {

        $data = $request->all();

        $orphan_program = Programs::where('status','orphan')->where('sport_id',$data['sport_id'])->first();

        $program = new Programs();
        $program->user_id = $data['user_id'];
        $program->sport_id = $data['sport_id'];
        $program->coach_id = $data['coach_id'];
        $program->nutrition_doctor_id = $data['nutrition_doctor_id'];
        $program->corrective_doctor_id = $data['corrective_doctor_id'];
        //$program->subscription_id = $data['subscription_id'];
        $program->start_date = $data['start_date'];
        //$program->status = $data['status'];
        $program->trainings_confirmation = false;
        $program->meals_confirmation = false;
        $program->federation_id = $data['federation_id'];
        $program->configuration = $orphan_program->configuration;
        $program->weight = $data['weight'];
        $program->abdominal = $data['abdominal'];
        $program->arm = $data['arm'];
        $program->wrist = $data['wrist'];
        $program->hip = $data['hip'];
        $program->waist = $data['waist'];
        $program->place_for_sport = $data['place_for_sport'];
        $program->time_of_exercises = $data['time_of_exercises'];
        $program->level = $data['level'];
        $program->target = $data['target'];
        $program->sport_habits = $data['sport_habits'];
        $program->nutrition_desc = $data['nutrition_desc'];
        $program->sport_desc = $data['sport_desc'];
        $program->description = $data['description'];
        $program->status = 'pending';
        $program->save();


        /* Todo: What will happen for subscription & Payment */


        return response()->json(['message' => 'برنامه اضافه شد'],200);

    }

}
