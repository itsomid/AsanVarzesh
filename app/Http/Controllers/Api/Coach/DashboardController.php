<?php

namespace App\Http\Controllers\Api\Coach;

use App\Model\Calendar;
use App\Model\Profiles;
use App\Model\Programs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index($date = null) {
        $coach = auth('api')->user();

        if($date == null) {
            $date_carbon = Carbon::today();
        } else {
            $date_carbon = Carbon::parse($date);
        }

//        $profiles = Profiles::take(10)->get();
//
//        //$calendar_today = [];
//        $calendar_today['public'] = [];
//        $calendar_today['specialized'] = [];
//
//
//
//
//        foreach ($profiles as $profile) {
//
//            $calendar_per_user = [
//
//                'day_number' => 3,
//                'time_exercise_from' => '2018-08-15 08:30:00',
//                'time_exercise_to' => '2018-08-15 10:30:00',
//                'status' => 'done',
//                'cycle' => 2,
//                'number_of_training' => 10,
//                'performed' => 5,
//                'training' => [
//                    'title' => 'دووی استقامت',
//                    'image' => 'http://asanvarzesh.lhost/images/placeholder.png'
//                ],
//                'user' => [
//                    'profile' => [
//                        'first_name' => $profile->first_name,
//                        'last_name' => $profile->last_name,
//                        'avatar' => $profile->avatar
//                    ]
//                ]
//
//            ];
//
//            array_push($calendar_today['public'],$calendar_per_user);
//
//
//        }
//
//
//        foreach ($profiles as $profile) {
//
//            $calendar_per_user = [
//
//                'day_number' => 3,
//                'time_exercise_from' => '2018-08-15 08:30:00',
//                'time_exercise_to' => '2018-08-15 10:30:00',
//                'status' => 'done',
//                'cycle' => 2,
//                'number_of_training' => 10,
//                'performed' => 5,
//                'training' => [
//                    'title' => 'دووی استقامت',
//                    'image' => 'http://asanvarzesh.lhost/images/placeholder.png'
//                ],
//                'user' => [
//                    'profile' => [
//                        'first_name' => $profile->first_name,
//                        'last_name' => $profile->last_name,
//                        'avatar' => $profile->avatar
//                    ]
//                ]
//
//            ];
//
//            array_push($calendar_today['specialized'],$calendar_per_user);
//
//
//        }
//
//
//        $response_json = $calendar_today;


        /*return $response_json;*/

        $coach_programs = Programs::where('coach_id',$coach->id)->get();
        $programs_by_types['public'] = [];
        $programs_by_types['specialized'] = [];

        foreach ($coach_programs as $coach_program)
        {
            if($coach_program->federation_id == 1)
            {
                array_push($programs_by_types['public'],$coach_program->id);
            } else {
                array_push($programs_by_types['specialized'],$coach_program->id);
            }

        }


        $calendars_by_types['public'] = [];
        $calendars_by_types['specialized'] = [];

        foreach ($programs_by_types as $key => $programs_by_type) {




            $calendars_by_user = Calendar::with(['training','user.profile'])
                ->whereIn('program_id',$programs_by_type)
                ->where('date',$date)
                ->where('training_id','!=',null)
                ->get()->groupBy('user_id');




            foreach ($calendars_by_user as $calendar_user) {

                $calendar = $calendar_user->toArray();
                $number_of_training = count($calendar);

                $trainings = [];
                $performed = 0;
                foreach ($calendar as $item) {
                    $item['training']['calendar_id'] = $item['id'];
                    array_push($trainings,$item['training']);
                    if($item['status'] == 'done')
                    {
                        $performed++;
                    }
                }

                $calendar_per_user = [
                    'day_number' => $calendar[0]['day_number'],
                    'time_exercise_from' => $calendar[0]['time_exercise_from'],
                    'time_exercise_to' => $calendar[0]['time_exercise_to'],
                    'cycle' => 2,
                    'number_of_training' => $number_of_training,
                    'performed' => $performed,
                    'training' => $trainings,
                    'user' => [
                        'id' => $calendar[0]['user']['id'],
                        'profile' => [
                            'first_name' => $calendar[0]['user']['profile']['first_name'],
                            'last_name' => $calendar[0]['user']['profile']['last_name'],
                            'avatar' => $calendar[0]['user']['profile']['avatar']
                        ]
                    ]
                ];

                if($key == 'public') {
                    array_push($calendars_by_types['public'],$calendar_per_user);
                } else {
                    array_push($calendars_by_types['specialized'],$calendar_per_user);
                }

            }



        }


        return $calendars_by_types;

    }




}
