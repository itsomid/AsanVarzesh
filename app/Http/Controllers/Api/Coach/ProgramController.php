<?php

namespace App\Http\Controllers\Api\Coach;

use App\Model\Programs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgramController extends Controller
{
    public function show($program_id)
    {
        $program = Programs::find($program_id);
        return $program;
    }

    public function update($program_id,Request $request)
    {
        return $data = $request->all();
        $program = Programs::find($program_id);
        $program->status = $data['status'];
        $program->text = $data['text'];
        $program->save();
        if ($program->status == 'active')
        {
            $status = 'برنامه تائید شد';
        }
        else
        {
            $status = "برنامه از طرف شما رد شد";
        }

        return response()->json(['message' => ''],200);

    }
}
