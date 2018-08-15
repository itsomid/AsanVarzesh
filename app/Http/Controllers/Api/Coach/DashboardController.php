<?php

namespace App\Http\Controllers\Api\Coach;

use App\Model\Profiles;
use App\Model\Programs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index($date = null) {

        if($date == null) {
            $date = Carbon::today()->format('y-m-d');
        }

        $profiles = Profiles::take(10)->get();

        //$calendar_today = [];
        $calendar_today['public'] = [];
        $calendar_today['specialized'] = [];




        foreach ($profiles as $profile) {

            $calendar_per_user = [

                'day_number' => 3,
                'time_exercise_from' => '2018-08-15 08:30:00',
                'time_exercise_to' => '2018-08-15 10:30:00',
                'status' => 'done',
                'cycle' => 2,
                'number_of_training' => 10,
                'performed' => 5,
                'training' => [
                    'title' => 'دووی استقامت',
                    'image' => 'http://asanvarzesh.lhost/images/placeholder.png'
                ],
                'user' => [
                    'profile' => [
                        'first_name' => $profile->first_name,
                        'last_name' => $profile->last_name,
                        'avatar' => $profile->avatar
                    ]
                ]

            ];

            array_push($calendar_today['public'],$calendar_per_user);


        }


        foreach ($profiles as $profile) {

            $calendar_per_user = [

                'day_number' => 3,
                'time_exercise_from' => '2018-08-15 08:30:00',
                'time_exercise_to' => '2018-08-15 10:30:00',
                'status' => 'done',
                'cycle' => 2,
                'number_of_training' => 10,
                'performed' => 5,
                'training' => [
                    'title' => 'دووی استقامت',
                    'image' => 'http://asanvarzesh.lhost/images/placeholder.png'
                ],
                'user' => [
                    'profile' => [
                        'first_name' => $profile->first_name,
                        'last_name' => $profile->last_name,
                        'avatar' => $profile->avatar
                    ]
                ]

            ];

            array_push($calendar_today['specialized'],$calendar_per_user);


        }


        $response_json = $calendar_today;


        return $response_json;

    }




}
