<?php

namespace App\Http\Controllers\Api\Coach;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserProfileController extends Controller
{
    public function show($user_id)
    {

        $response_json = [];

        $response_json = [
            'user' => [
                'id' => 2,
                'profile' => [
                    'first_name' => 'محمد',
                    'last_name' => 'ریاحی',
                    'avatar' => 'http://asanvarzesh.lhost/images/placeholder.png',
                    'birth_date' => '1987-09-09',
                    'city' => 'تهران',
                    'height' => '180',

                ],
                'sport_by_coach' => [
                    'id' => 1,
                    'title' => 'تناسب اندام',
                    'image' => 'http://asanvarzesh.lhost/images/placeholder.png'

                ],
                'active_programs' => [
                    [
                        'id' => 1,
                        'sport' => [
                            'title' => 'تناسب اندام',
                            'image' => 'http://asanvarzesh.lhost/images/placeholder.png'
                        ],
                        'start_date' => '2018-08-15 08:30:00',
                        'level' => 'amateur'
                    ],
                    [
                        'id' => 2,
                        'sport' => [
                            'title' => 'ژیمناستیک',
                            'image' => 'http://asanvarzesh.lhost/images/placeholder.png'
                        ],
                        'start_date' => '2018-08-15 08:30:00',
                        'level' => 'professional'
                    ]
                ]
            ],
            'activities' => []

        ];


        return $response_json;

    }

    public function diet($user_id) {

        $response_json = [];
        $all_diets = [];
        for ($i = 0;$i <=6;$i++) {
            $a_day = [
                'day_number' => $i,
                'package' => [
                    'title' => "صبحانه ",
                    'size' => 2,
                    'unit' => "number",
                    'foods' => [
                        [
                            "id" => 1,
                            "title" => "تخم مرغ",
                            "description" => "تخم مرغ",
                            "details" => "تخم مرغ",
                            "energy" => 35
                        ],
                        [
                            "id" => 1,
                            "title" => "نان سنگک",
                            "description" => "نان سنگک",
                            "details" => "نان سنگک",
                            "energy" => 35
                        ]
                    ]
                ]
            ];
            array_push($all_diets,$a_day);


        }

        return $response_json = $all_diets;

    }

    public function trainings($user_id) {

        $response_json = [];

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

        return $response_json;

    }
}
