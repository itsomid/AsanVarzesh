<?php

namespace App\Http\Controllers\Api\Coach;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SportTypeController extends Controller
{

    public function index()
    {

        $response_json = [];

        $response_json = [

            [
                'id' => 1,
                'title' => 'تناسب اندام',
                'image' => 'http://asanvarzesh.lhost/images/placeholder.png'

            ],
            [
                'id' => 2,
                'title' => 'تناسب اندام',
                'image' => 'http://asanvarzesh.lhost/images/placeholder.png'

            ],
            [
                'id' => 6,
                'title' => 'تناسب اندام',
                'image' => 'http://asanvarzesh.lhost/images/placeholder.png'

            ]

        ];

        return $response_json;

    }

    public function show($sport_id)
    {

        $response_json = [];

        $response_json = [

            [
                'level' => 'semi-professional',
                'days_number_exercise' => 3,
                'day_number' => 24,
                'status' => 'active',
                'user' => [
                    'id' => 2,
                    'profile' => [
                        'first_name' => 'محمد',
                        'last_name' => 'ریاحی',
                        'avatar' => 'http://asanvarzesh.lhost/images/placeholder.png'
                    ]
                ],

            ],
            [
                'level' => 'professional',
                'days_number_exercise' => 3,
                'day_number' => 24,
                'status' => 'accept',
                'user' => [
                    'id' => 2,
                    'profile' => [
                        'first_name' => 'محمد',
                        'last_name' => 'ریاحی',
                        'avatar' => 'http://asanvarzesh.lhost/images/placeholder.png'
                    ]
                ],
            ],
            [
                'level' => 'amateur',
                'days_number_exercise' => 3,
                'day_number' => 24,
                'status' => 'pending',
                'user' => [
                    'id' => 2,
                    'profile' => [
                        'first_name' => 'محمد',
                        'last_name' => 'ریاحی',
                        'avatar' => 'http://asanvarzesh.lhost/images/placeholder.png'
                    ]
                ],
            ]

        ];
        return $response_json;
    }



}
