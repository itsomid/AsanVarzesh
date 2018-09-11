<?php

namespace App\Http\Controllers\Api\Coach;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserTrainingController extends Controller
{

    public function userTraining($user_id)
    {


        /*$response_json = [];
        $response_json = [
            'user' => [
                'id' => $user_id,
                'profile' => [
                    'first_name' => 'محمد',
                    'last_name' => 'ریاحی'
                ],
                'today_training' => [
                    [
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
                        ]
                    ],
                    [
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
                        ]
                    ],
                    [
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
                        ]
                    ],
                    [
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
                        ]
                    ]
                ],
                'today_nutrition' => []

            ]

        ];

        return $response_json;*/

        $user = User::with(['profile','today_training.training'])->find($user_id);

        return $user;

    }

}
