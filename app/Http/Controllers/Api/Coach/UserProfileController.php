<?php

namespace App\Http\Controllers\Api\Coach;

use App\Model\Calendar;
use App\Model\Programs;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserProfileController extends Controller
{
    public function show($user_id)
    {

        $coach = auth('api')->user();

        $user = User::with([
            'profile',
            'active_programs.sport',
            'sport_by_coach' =>function($q){$q->with('sport');},
            ])->where('id',$user_id)->first()->toArray();

        $program = Programs::where('user_id',$user_id)
                            ->where('coach_id',$coach->id)
                            ->orderBy('id','DESC')
                            ->first();

        $calendar = $program->calendar->groupBy('date')->toArray();
        reset($calendar);
        $first_day = key($calendar);

        end($calendar);
        $last_day = key($calendar);

        $user['first_day'] = $first_day;
        $user['last_day'] = $last_day;
        return $user;




    }

    public function diet($user_id) {

        $calendars = Calendar::where('user_id',$user_id)
            ->where('training_id','=',null)
            ->orderby('id','DESC')
            ->with(['training','meal','package.foods'])
            ->get()->groupBy('date','user_id');

        $transformed_calendars = [];

        foreach ($calendars as $calendar) {

            array_push($transformed_calendars,$calendar);

        }

        return $transformed_calendars;
        //return $calendars;

    }

    public function trainings($user_id) {

        /*$response_json = [];

        for ($i = 1; $i <= 15; $i++) {

            $perday = [
                'day_number' => $i,
                'time_exercise_from' => '2018-08-1'.$i.' 08:00:00',
                'time_exercise_to' => '2018-08-1'.$i.' 10:00:00',
                'training' => [
                    [
                        'title' => 'دووی استقامت',
                        'steps' => [
                            [
                                'text' => '۱۵ دقیقه گرم کردن',
                                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
                            ]
                        ],
                        'difficulty' => 'Easy',
                        'details' => '',
                        'attribute' => [
                            'distance' => 1000,
                            'time' => 600,
                            'speed' => '44',
                            'unit_speed' => 'km',
                            'set' => 4,
                            'each_set' => 10,
                            'time_each_set' => null
                        ]
                    ],
                    [
                        'title' => 'تمرینات کششی',
                        'steps' => [
                            [
                                'text' => '۱۵ دقیقه گرم کردن',
                                'attachment' => 'http://techslides.com/demos/sample-videos/small.mp4'
                            ]
                        ],
                        'difficulty' => 'Easy',
                        'details' => '',
                        'attribute' => [
                            'distance' => 1000,
                            'time' => 600,
                            'speed' => '44',
                            'unit_speed' => 'km',
                            'set' => 4,
                            'each_set' => 10,
                            'time_each_set' => null
                        ]
                    ]
                ]
            ];


            array_push($response_json,$perday);

        }

        return $response_json;*/

        $calendars = Calendar::where('user_id',$user_id)
                            ->where('training_id','!=',null)
                            ->orderby('id','DESC')
                            ->with('training')
                            ->get()->groupBy('date','user_id');

        $transformed_calendars = [];

        foreach ($calendars as $calendar) {

            array_push($transformed_calendars,$calendar);

        }

        return $transformed_calendars;

        return $calendars;

    }
}
