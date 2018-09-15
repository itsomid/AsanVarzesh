<?php

namespace App\Http\Controllers\Api\Coach;

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

        $program = Programs::with('subscription')->find($program_id);
        $times_date = $program->time_of_exercises;
        $times_date_arr = [];
        foreach ($times_date as $item) {
            array_push($times_date_arr,$item['day_number']);
        }
        $trainings_default = $program->configuration['trainings'];
        $start_date = $program->start_date;
        /*$selected_start_days = [];
        foreach ($times_date as $item) {
            array_push($selected_start_days, strtotime('next '.$this->week_days( $item['day_number']), strtotime($start_date)));
        }

        sort($selected_start_days);
        $selected_start_days_date = [];

        $date = new \DateTime();

        foreach ($selected_start_days as $day)
        {
            array_push($selected_start_days_date,date('Y-m-d 00:00:00', $day));
        }


        // Update Subscription if first selected start day Bigger than Subscription Start Date

        if(strtotime($selected_start_days_date[0]) >= strtotime($program->subscription->from)) {

            $to = Carbon::parse($selected_start_days_date[0])->addDay(30);
            $program->subscription->from = $selected_start_days_date[0];
            $program->subscription->to = $to;
            $program->subscription->save();

        }*/

        $trainings_transformed = [];

        foreach ($trainings_default as $training_day) {
            $training_day_array['trainings'] = [];
            $training_day_array['day_number'] = $training_day['day_number'];

            if(in_array($training_day['day_number'],$times_date_arr)) {

                foreach ($training_day['training'] as $training) {
                    $training_item = Training::find($training['training_id'])->toArray();

                    $training_item['attributes'] = $training['attribute'];
                    array_push($training_day_array['trainings'],$training_item);
                }
                array_push($trainings_transformed,$training_day_array);
            } else {
                array_push($trainings_transformed,$training_day_array);
            }


        }

        return $trainings_transformed;






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
