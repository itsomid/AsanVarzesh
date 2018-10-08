<?php
/**
 * Created by PhpStorm.
 * User: Ali A. Jafari
 * Date: 9/8/2018
 * Time: 7:12 PM
 */
namespace App\Helpers;

use App\Model\Calendar;
use App\Model\Conversation;
use App\Model\Programs;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class GenerateCalendar
{

    public function generate($program_id,$cycle)
    {

        $program = Programs::with('subscription')->find($program_id);
        $times_date = $program->time_of_exercises;
        $times_date_arr = [];
        foreach ($times_date as $item) {
            array_push($times_date_arr, $item['day_number']);
        }

        $start_date = $program->start_date;
        $selected_start_days = [];
        foreach ($times_date as $item) {
            array_push($selected_start_days, strtotime('next ' . $this->week_days($item['day_number']), strtotime($start_date)));
        }

        sort($selected_start_days);
        $selected_start_days_date = [];

        $date = new \DateTime();

        foreach ($selected_start_days as $day) {
            array_push($selected_start_days_date, date('Y-m-d 00:00:00', $day));
        }


        // Update Subscription if first selected start day Bigger than Subscription Start Date

        if (strtotime($selected_start_days_date[0]) >= strtotime($program->subscription->from)) {

            $to = Carbon::parse($selected_start_days_date[0])->addDay(30);
            $program->subscription->from = $selected_start_days_date[0];
            $program->subscription->to = $to;
            $program->subscription->save();

        }

        $trainings = $program->configuration['trainings'];

        $nutrition = $program->configuration['nutrition'];


        if ($cycle == 1) {
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

            if(in_array($training['day_number'],$times_date_arr)) {

                foreach ($trainings_day as $training_item) {

                    $new_calendar_item = new Calendar();
                    $new_calendar_item->day_number = $training['day_number']+1;
                    $new_calendar_item->user_id = $program->user_id;
                    if(count($training_item['attribute']) == 0) {
                        $att = null;
                    } else {
                        $att = $training_item['attribute'];
                    }
                    $new_calendar_item->attributes = $att;
                    //$new_calendar_item->package_id = null;
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
                    //$new_calendar_item->save();
                    $new_calendar_item->save();


                }

            } else {
                $new_calendar_item = new Calendar();
                $new_calendar_item->day_number = $training['day_number']+1;
                $new_calendar_item->user_id = $program->user_id;
                $new_calendar_item->attributes = '';
                //$new_calendar_item->package_id = null;
                $new_calendar_item->training_id = null;
                $new_calendar_item->meal_id = null;
                $new_calendar_item->date = $date;
                $new_calendar_item->time_exercise_from = null;
                $new_calendar_item->time_exercise_to = null;
                $new_calendar_item->status = 'did_not_do';
                $new_calendar_item->type = 'training';
                $new_calendar_item->program_id = $program->id;
                $new_calendar_item->comment = '';
                $new_calendar_item->description = '';

                $new_calendar_item->save();


            }



        }

        foreach ($nutrition as $item)
        {
            $date = Carbon::parse($start_date)->addDay($item['day_number']);
            foreach ($item['meals'] as $meal) {

                $new_calendar_item = new Calendar();
                $new_calendar_item->day_number = $item['day_number']+1;
                $new_calendar_item->user_id = $program->user_id;
                $new_calendar_item->attributes = $meal;
                //$new_calendar_item->package_id = $meal['package_id'];
                $new_calendar_item->training_id = null;
                $new_calendar_item->meal_id = $meal['meal_id'];
                $new_calendar_item->date = $date;
                $new_calendar_item->time_exercise_from = null;
                $new_calendar_item->time_exercise_to = null;
                $new_calendar_item->status = 'did_not_do';
                $new_calendar_item->type = 'package';
                $new_calendar_item->program_id = $program->id;
                $new_calendar_item->comment = '';
                $new_calendar_item->description = '';
                $new_calendar_item->save();
                if(isset($meal['familiar'])) {
                    $new_calendar_item->package()->attach($meal['familiar']);
                }

            }

        }

        $conv = Conversation::where('program_id',$program->id)->first();
        if($conv == null) {
            $read_status = [
                $program->user->id => false,
                $program->coach->id => false,
                $program->nutrition_doctor->id => false,
                $program->corrective_doctor->id => false
            ];
            $conversation = new Conversation();
            $conversation->program_id = $program->id;
            $conversation->started_by = null;
            $conversation->title = 'گفتگوی گروهی';
            $conversation->read_status = $read_status;
            $conversation->save();
            $conversation->user()
                ->sync([
                    $program->coach_id,
                    $program->user_id,
                    $program->nutrition_doctor_id,
                    $program->corrective_doctor_id
                ]);

        }


        $program->status = 'active';

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