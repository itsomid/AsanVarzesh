<?php

namespace App\Http\Controllers\Api\Coach;

use App\Model\Programs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RequestsController extends Controller
{

    public function index() {

        $response_json = [];

        $programs = Programs::where('status','orphan')->get();

        foreach ($programs as $program) {

            $program = [
                'user' => [
                    'id' => 2,
                    'profile' => [
                        'first_name' => 'محمد',
                        'last_name' => 'ریاحی',
                        'avatar' => 'http://asanvarzesh.lhost/images/placeholder.png',
                        'birth_date' => '1987-09-09'
                    ]
                ],
                'sport' => [
                    'id' => $program->sport->id,
                    'title' => $program->sport->title,
                    'image' => 'http://asanvarzesh.lhost/images/placeholder.png',
                ],
                'weight' => 90,
                'abdominal' => 75,
                'arm' => 20,
                'wrist' => 65,
                'hip' => 80,
                'waist' => 80,
                'place_for_sport' => 'منزل',
                'time_of_exercises' => [
                    [
                        'day' => 0,
                        'enable' => true,
                        'time' => '8-11',
                    ],
                    [
                        'day' => 1,
                        'enable' => true,
                        'time' => '8-11',
                    ],
                    [
                        'day' => 2,
                        'enable' => true,
                        'time' => '8-11',
                    ],
                    [
                        'day' => 3,
                        'enable' => true,
                        'time' => '8-11',
                    ],
                    [
                        'day' => 4,
                        'enable' => true,
                        'time' => '8-11',
                    ],
                    [
                        'day' => 5,
                        'enable' => true,
                        'time' => '8-11',
                    ],
                    [
                        'day' => 6,
                        'enable' => true,
                        'time' => '8-11',
                    ]

                ],
                'level' => 'amateur',
                'target' => 'کاهش وزن',

            ];

            array_push($response_json,$program);

        }


        return $response_json;

    }


    public function show($program_id)
    {

        $response_json = [
            "id" => 6,
            "start_date" => '2018-09-09',
            "weight" => 90,
            "abdominal" => 60,
            "arm" => 35,
            "wrist" => 45,
            "hip" => 70,
            "waist" => 60,
            "place_for_sport" => 'منزل',
            "time_of_exercises" => [
                [
                    'day_number' => 0,
                    'enable' => true,
                    'time' => '8-11'
                ],
                [
                    'day_number' => 1,
                    'enable' => true,
                    'time' => '8-11'
                ],
                [
                    'day_number' => 2,
                    'enable' => true,
                    'time' => '8-11'
                ],
                [
                    'day_number' => 3,
                    'enable' => true,
                    'time' => '8-11'
                ],
                [
                    'day_number' => 4,
                    'enable' => true,
                    'time' => '8-11'
                ],
                [
                    'day_number' => 5,
                    'enable' => true,
                    'time' => '8-11'
                ],
                [
                    'day_number' => 6,
                    'enable' => true,
                    'time' => '8-11'
                ]
            ],
            "level" => "amateur",
            "target" => 'تناسب اندام',
            "description" => 'توضیحات',
            "user" => [
                "id" => 5,
                "email" => null,
                "mobile" => "09178465144",
                "code" => 0,
                "permissions" => null,
                "steps" => "login_register",
                "status" => "active",
                "referal_code" => null,
                "referer_id" => null,
                "last_login" => null,
                "profile"  => [
                    "id" => 5,
                    "user_id" => 5,
                    "first_name" => "طهمورث",
                    "last_name" => "گل",
                    "text" => null,
                    "covered_area" => "گیشا - شهرآرا - ستارخان",
                    "avatar" => "http://cdn.isna.ir/d/2016/06/20/3/57306107.jpg",
                    "photos"  => [
                        "http://cdn.isna.ir/d/2016/06/20/3/57306107.jpg",
                        "https://www.tarafdari.com/sites/default/files/contents/user241416/content-note/mhrb-ftmy.jpg"
                    ],
                    "height"  => null,
                    "blood_type"  => "O-",
                    "diseases"  => [
                        'بیماری 1',
                        'بیماری 2'
                    ],
                    "maim"  => [
                        ' قطع عضو 1',
                        'قطع عضو 2'
                    ],
                    "city_id" => 117,
                    "address" => "استان آذربایجان غربی خیابان حقیقی ساختمان سوسنک کد پستی 4672180822",
                    "keywords" => "طهمورث - گل - طهمورث گل",
                    "nutrition_info" => null,
                    "gender" => "male",
                    "birth_date" => '1987-09-09'
                ]
            ]

        ];



        return $response_json;

    }

    public function update($status) {

        return [
            'message' => 'عملیات مورد نظر انجام شد',
            'status' => 200
        ];

    }
}
