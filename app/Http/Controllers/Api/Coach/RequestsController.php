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
}
