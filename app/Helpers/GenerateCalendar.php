<?php
/**
 * Created by PhpStorm.
 * User: Ali A. Jafari
 * Date: 9/8/2018
 * Time: 7:12 PM
 */
namespace App\Helpers;

use App\Model\Calendar;
use App\Model\Programs;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class GenerateCalendar
{

    public function generate($program_id,$cycle) {

        $program = Programs::with('subscription')->find($program_id);
        $times_date = $program->time_of_exercises;
        $times_date_arr = [];
        foreach ($times_date as $item) {
            array_push($times_date_arr,$item['day_number']);
        }

        $start_date = $program->start_date;
        $selected_start_days = [];
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

        }

        $trainings = $program->configuration['trainings'];
        $nutrition = $program->configuration['nutrition'];

        if($cycle == 1) {
            $start_date = $program->subscription->from;
        } else {

        }

        foreach ($trainings as $training)
        {

            $date = Carbon::parse($start_date)->addDay($training['day_number']);
            $start_time_training = $date;
            $end_time_training = $date;
            /*if(in_array($date,$selected_start_days_date)) {
                echo $date.'<br/>';
            }*/

            foreach ($times_date as $item) {
                if($item['day_number'] == $training['day_number']) {
                    $date->format('Y-m-d').' '.$item['start_time'];
                    $start_time_training  = Carbon::parse($date->format('Y-m-d').' '.$item['start_time']);
                    $end_time_training = Carbon::parse($date->format('Y-m-d').' '.$item['end_time']);
                }
            }

            $trainings_day = $training['training'];
            foreach ($trainings_day as $training_item) {


                $new_calendar_item = new Calendar();
                $new_calendar_item->day_number = $training['day_number']+1;
                $new_calendar_item->user_id = $program->user_id;
                $new_calendar_item->items = $training_item['attribute'];
                $new_calendar_item->package_id = null;
                $new_calendar_item->training_id = $training_item['training_id'];
                $new_calendar_item->meal_id = null;
                $new_calendar_item->date = $date;
                $new_calendar_item->time_exercise_from = $start_time_training;
                $new_calendar_item->time_exercise_to = $end_time_training;
                $new_calendar_item->status = 'did_not_do';
                $new_calendar_item->type = 'training';
                $new_calendar_item->program_id = $program->id;
                $new_calendar_item->comment = '';
                $new_calendar_item->description = '';
                //return $new_calendar_item;
                $new_calendar_item->save();
            }


        }

    }

    public function week_days($index) {

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