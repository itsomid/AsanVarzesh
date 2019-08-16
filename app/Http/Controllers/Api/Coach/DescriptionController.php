<?php

namespace App\Http\Controllers\Api\Coach;

use App\Model\DescriptionDays;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DescriptionController extends Controller
{
    public function show($program_id,$day_number)
    {
        $description = DescriptionDays::where('program_id',$program_id)->where('day_number',$day_number)->first();
        return $description;
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $description = new DescriptionDays();

        $description->program_id = $data['program_id'];
        $description->day_number = $data['day_number'];
        $description->body = $data['body'];
        $description->save();

        return response()->json(
            [
                'description' => $description,
            ],
            200
        );
    }

    public function update($description_id,Request $request)
    {
        $data = $request->all();

        $description = DescriptionDays::find($description_id);
        $description->program_id = $data['program_id'];
        $description->day_number = $data['day_number'];
        $description->body = $data['body'];
        $description->save();

        return response()->json(
            [
                'description' => $description,
            ],
            200
        );

    }

}
