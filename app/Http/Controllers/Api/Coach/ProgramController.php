<?php

namespace App\Http\Controllers\Api\Coach;

use App\Model\Programs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgramController extends Controller
{
    public function show($program_id)
    {
        return $program = Programs::find($program_id);
        $caledar_template = [];
        foreach ($program->configuration as $value) {

            dd($value);

        }
        return $program;
    }

    public function update($program_id,Request $request)
    {
        $data = $request->all();
        $program = Programs::find($program_id);
        $program->status = $data['status'];
        $program->description = $data['description'];
        $program->save();

        if ($program->status == 'accept')
        {
            $status = 'برنامه تائید شد';
        }
        else
        {
            $status = "برنامه از طرف شما رد شد";
        }


        return response()->json(['message' => $status],200);

    }
}
