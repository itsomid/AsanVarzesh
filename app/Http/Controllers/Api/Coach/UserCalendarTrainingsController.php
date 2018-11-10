<?php

namespace App\Http\Controllers\Api\Coach;

use App\Model\Calendar;
use App\Model\Programs;
use App\Model\Training;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserCalendarTrainingsController extends Controller
{
    public function showTrainings($program_id)
    {

        $calendar_trainings = Calendar::with('training.accessories')
            ->where('type','training')
            ->where('program_id',$program_id)
            /*->where('training_id','!=',null)*/
            ->orderby('id','DESC')
            ->get()
            ->groupBy('date')->toArray();

        $calendar_trainings_arr = [];

        foreach ($calendar_trainings as $training) {
            array_push($calendar_trainings_arr,$training);
        }



        return response()->json([
            'trainings' => $calendar_trainings_arr,
            //'nutrition' => $calendar_nutrition_arr
        ],200);






    }

    public function updateTrainings(Request $request)
    {


        $data = $request->all();
        $program = Programs::find($data['program_id']);
        if($program->trainings_confirmation == false && $program->status == 'accept') {

            //$program->configuration = ['trainings' => $data['trainings'],'nutrition' => $program->configuration['nutrition']];
            $program->trainings_confirmation = true;
            $program->save();


            if($program->trainings_confirmation == true && $program->meals_confirmation == true) {

                $program->status = 'accept';
                $program->save();

            }

            return response()->json([
                'status' => 200,
                'message' => 'برنامه تمرینی تائید شد'
            ]);

        } else {

            return response()->json([
                'status' => 301,
                'message' => 'برنامه تمرینی قبلا تائید شده است'
            ]);

        }








    }

    public function createItem(Request $request) {
        $data = $request->all();

        $calendar = new Calendar();

        foreach ($data['items'] as $item) {
            $program = Programs::find($item['program_id']);
            $calendar->day_number = $item['day_number'];
            $calendar->program_id = $item['program_id'];
            $calendar->training_id = $item['training_id'];
            $calendar->attributes = $item['attributes'];
            $calendar->type = 'training';
            $calendar->user_id = $program->user_id;
            $calendar->save();
        }


        return response()->json([
            'message' => 'آیتم جدید اضافه شد'
        ],200);

    }

    public function updateItem(Request $request) {
        $data = $request->all();
        foreach ($data['items'] as $item) {
            $calendar = Calendar::where('id', $item['calendar_id'])->first();
            $calendar->training_id = $item['training_id'];
            $calendar->attributes = $item['attributes'];
            $calendar->save();
        }
        return response()->json([
            'message' => 'آیتم مورد نظر تغییر کرد'
        ],200);

    }


}
