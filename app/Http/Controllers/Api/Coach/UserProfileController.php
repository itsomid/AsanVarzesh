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
}
