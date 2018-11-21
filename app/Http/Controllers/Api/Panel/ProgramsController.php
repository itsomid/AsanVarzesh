<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Programs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgramsController extends Controller
{

    public function index($status = null)
    {

        if($status == null) {
            $status = 'orphan';
        }

        $programs = Programs::with('sport')->where('status',$status)->get();

        return response($programs,200);

    }

    public function store(Request $request)
    {

        $data = $request->all();
        $program = Programs::where('sport_id',$data['sport_id'])->where('status','orphan')->first();
        if($program != null ) {
            return response()->json(['message' => 'برای این ورزش یک برنامه پیش فرض ساخته شده است'],406);
        }

        $orphan_program = new \App\Model\Programs();
        $orphan_program->user_id = 0;
        $orphan_program->sport_id = $data['sport_id'];
        $orphan_program->coach_id = 0;
        $orphan_program->nutrition_doctor_id = 0;
        $orphan_program->corrective_doctor_id = 0;
        $orphan_program->subscription_id = 0;
        $orphan_program->start_date = null;
        $orphan_program->status = 'orphan';
        $orphan_program->federation_id = 1;
        $orphan_program->configuration = $data['configuration'];
        $orphan_program->save();

        return response()->json(['message' => 'برنامه پیش فرض ساخته شد'],200);


    }

}
