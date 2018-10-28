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

            $program->configuration = ['trainings' => $data['trainings'],'nutrition' => $program->configuration['nutrition']];
            $program->trainings_confirmation = true;
            $program->save();


            if($program->trainings_confirmation == true && $program->meals_confirmation == true) {
                $program->status = 'accept';
                $program->save();

                $generateCalendar = new \App\Helpers\GenerateCalendar();
                return $generateCalendar->generate($program->id,1);


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

    protected function week_days($index) {

        $days = [
            0 => 'Saturday',
            1 => 'Sunday',
            2 => 'Monday',
            3 => 'Tuesday',
            4 => 'Wednesday',
            5 => 'Thursday',
            6 => 'Friday',
        ];

//        $date = new \DateTime();
//        $date->modify('next '.$days[$index]);
//        $date->format('Y-m-d 00:00:00');
        return $days[$index];
    }


}
