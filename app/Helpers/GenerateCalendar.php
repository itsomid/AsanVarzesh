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
use App\Model\Meal;
use App\Model\Programs;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class GenerateCalendar
{

    public function generate($program_id,$cycle)
    {

        $today = Carbon::today();

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

        foreach ($selected_start_days as $day) {
            array_push($selected_start_days_date, date('Y-m-d 00:00:00', $day));
        }

        //return $selected_start_days_date;


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

        $selected_days_by_name = [];
        foreach ($times_date as $day) {
            array_push($selected_days_by_name,$this->week_days($day['day_number']));
        }


        $j = 0;
        foreach ($trainings as $training)
        {

            if($training['day_number'] == 1) {
                $date = Carbon::parse($today);
            } else {
                $date = Carbon::parse($today)->addDay($training['day_number'] - 1);
            }


            if(in_array($date->dayName,$selected_days_by_name)) {

                $start_time_training  = Carbon::parse($date->format('Y-m-d').' '.$item['start_time']);
                $end_time_training = Carbon::parse($date->format('Y-m-d').' '.$item['end_time']);

                $trainings_day = $training['training'];

                foreach ($trainings_day as $training_item) {

                    $new_calendar_item = new Calendar();
                    $new_calendar_item->day_number = $training['day_number'];
                    $new_calendar_item->user_id = $program->user_id;

                    if(count($training_item['attribute']) == 0) {
                        $att = null;
                    } else {
                        $att = $training_item['attribute'];
                    }


                    $new_calendar_item->attributes = $att;

                    $desc = $training_item['day_description'];
                    $new_calendar_item->description = $desc;
                    $new_calendar_item->training_id = $training_item['training_id'];
                    $new_calendar_item->order = $training_item['order'];
                    $new_calendar_item->meal_id = null;
                    $new_calendar_item->date = $date;
                    $new_calendar_item->time_from = $start_time_training;
                    $new_calendar_item->time_to = $end_time_training;
                    $new_calendar_item->status = 'did_not_do';
                    $new_calendar_item->type = 'training';
                    $new_calendar_item->program_id = $program->id;
                    $new_calendar_item->comment = '';
                    //return $new_calendar_item;
                    //$new_calendar_item->save();
                    $new_calendar_item->save();


                }

            } else {
                $new_calendar_item = new Calendar();
                $new_calendar_item->day_number = $training['day_number'];
                $new_calendar_item->order = 0;
                $new_calendar_item->user_id = $program->user_id;
                $new_calendar_item->description = 1;
                $new_calendar_item->attributes = null;
                //$new_calendar_item->package_id = null;
                $new_calendar_item->training_id = null;
                $new_calendar_item->meal_id = null;
                $new_calendar_item->date = $date;
                $new_calendar_item->time_from = null;
                $new_calendar_item->time_to = null;
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

            if($item['day_number'] == 1) {
                $date = Carbon::parse($today);
            } else {
                $date = Carbon::parse($today)->addDay($item['day_number'] - 1);
            }

            foreach ($item['meals'] as $meal) {

                $meal_item = Meal::find($meal['meal_id']);

                $new_calendar_item = new Calendar();
                $new_calendar_item->day_number = $item['day_number'];
                $new_calendar_item->user_id = $program->user_id;
                $new_calendar_item->attributes = $meal;
                $new_calendar_item->order = 0;
                //$new_calendar_item->package_id = $meal['package_id'];
                $new_calendar_item->training_id = null;
                $new_calendar_item->meal_id = $meal['meal_id'];
                $new_calendar_item->date = $date;
                $new_calendar_item->time_from = Carbon::parse($date->format('Y-m-d').' '.$meal_item->time_from);
                $new_calendar_item->time_to = Carbon::parse($date->format('Y-m-d').' '.$meal_item->time_to);
                $new_calendar_item->status = 'did_not_do';
                $new_calendar_item->type = 'package';
                $new_calendar_item->program_id = $program->id;
                $new_calendar_item->comment = '';
                $new_calendar_item->description = '';
                $new_calendar_item->save();
                if(isset($meal['package'])) {
                    $new_calendar_item->package()->attach($meal['package']);
                }

            }

        }

        $conv = Conversation::where('program_id',$program->id)->first();
        if($conv == null) {


            // Group Conversation
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
            $conversation->type = 'group';
            $conversation->save();
            $conversation->user()
                ->sync([
                    $program->coach_id,
                    $program->user_id,
                    $program->nutrition_doctor_id,
                    $program->corrective_doctor_id
                ]);

            $users = [
                $program->user->id,
                $program->coach->id,
                $program->nutrition_doctor->id,
                $program->corrective_doctor->id

            ];

            foreach ($users as $user) {

                foreach ($users as $second_user) {

                    if($second_user > $user) {

                        $read_status = [
                            $second_user => false,
                            $user => false
                        ];
                        $conversation = new Conversation();
                        $conversation->program_id = $program->id;
                        $conversation->started_by = null;
                        $conversation->title = 'مکالمه خصوصی';
                        $conversation->read_status = $read_status;
                        $conversation->program_id = $program->id;
                        $conversation->save();
                        $conversation->user()
                            ->sync([
                                $second_user,
                                $user
                            ]);

                    }


                }

            }
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