<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',function() {
   return 'index page';
});

Route::group(['middleware' => ['CheckAuth','UserRole']], function () {

    Route::get('/protect',function(){
        return '/protect';
    });

});

Route::get('orphan',function() {

    $program = \App\Model\Programs::find(1);
    return $program->configuration['trainings'];

});

Route::get('fake',function() {
    $date = '2018-09-09';
    $start_date = explode('-',$date);
    $date = \Carbon\Carbon::create($start_date[0],$start_date[1],$start_date[2],00,00,00);

    $carbon_date = \Carbon\Carbon::parse($date);
    $from_hour = $carbon_date->addHours(6);
    $carbon_date = \Carbon\Carbon::parse($date);
    $to_hour = $carbon_date->addHours(11);

    return $from_hour;

//    $add_day = $day->addDay(1);
//    $day_from = $add_day->addHour(8);
//    $day_to = $add_day->addHour(10);


    //return $new;

    /*$trainings = \App\Model\Training::pluck('id')->toArray();
    return array_random($trainings,1)[0];*/

    /*$coach_role = \App\Model\Role::find(3);
    return $coaches = $coach_role->users;*/


    /*$user_role = \App\Model\Role::find(2);
    $users = $user_role->users;*/

    /*$nutrition_role = \App\Model\Role::find(4);
    $nutrition_doctor = $nutrition_role->users;
    $nutrition_doctor_arr = [];
    foreach ($nutrition_doctor as $value) {
        array_push($nutrition_doctor_arr,$value->id);
    }


    $corrective_role = \App\Model\Role::find(5);
    $corrective_doctor = $corrective_role->users;
    $corrective_doctor_arr = [];
    foreach ($corrective_doctor as $value) {
        array_push($corrective_doctor_arr,$value->id);
    }

    $coach_team = [];
    $all = [];
    foreach ($coaches as $coach) {

        array_push($all,[$coach->id,array_rand($nutrition_doctor_arr,1),array_rand($corrective_doctor_arr,1)]);

    }

    return $all;*/


});

Route::get('gender',function() {

    $faker = \Faker\Factory::create('fa_IR');
    $gender = $faker->randomElements(['male', 'female']);
    return [$faker->firstName('female')];
});

Route::get('default-program',function () {

    $training = [
        [
            'day_number' => 0,
            'training' => [
                [
                    'training_id' => 2,
                    'attribute' => [
                        'distance' => null,
                        'time' => 30,
                        'speed' => '44',
                        'unit_speed' => 'km',
                        'set' => 4,
                        'each_set' => 10,
                        'time_each_set' => 65
                    ]
                ],
                [
                    'training_id' => 3,
                    'attribute' => [
                        'distance' => null,
                        'time' => 30,
                        'speed' => '44',
                        'unit_speed' => 'km',
                        'set' => 4,
                        'each_set' => 10,
                        'time_each_set' => 65
                    ]
                ]
            ]
        ],
        [
            'day_number' => 1,
            'training' => [
                [
                    'training_id' => 2,
                    'attribute' => [
                        'distance' => null,
                        'time' => 30,
                        'speed' => '44',
                        'unit_speed' => 'km',
                        'set' => 4,
                        'each_set' => 10,
                        'time_each_set' => 65
                    ]
                ],
                [
                    'training_id' => 3,
                    'attribute' => [
                        'distance' => null,
                        'time' => 30,
                        'speed' => '44',
                        'unit_speed' => 'km',
                        'set' => 4,
                        'each_set' => 10,
                        'time_each_set' => 65
                    ]
                ]
            ]
        ],
        [
            'day_number' => 2,
            'training' => [
                [
                    'training_id' => 2,
                    'attribute' => [
                        'distance' => null,
                        'time' => 30,
                        'speed' => '44',
                        'unit_speed' => 'km',
                        'set' => 4,
                        'each_set' => 10,
                        'time_each_set' => 65
                    ]
                ],
                [
                    'training_id' => 3,
                    'attribute' => [
                        'distance' => null,
                        'time' => 30,
                        'speed' => '44',
                        'unit_speed' => 'km',
                        'set' => 4,
                        'each_set' => 10,
                        'time_each_set' => 65
                    ]
                ]
            ]
        ],
        [
            'day_number' => 3,
            'training' => [
                [
                    'training_id' => 2,
                    'attribute' => [
                        'distance' => null,
                        'time' => 30,
                        'speed' => '44',
                        'unit_speed' => 'km',
                        'set' => 4,
                        'each_set' => 10,
                        'time_each_set' => 65
                    ]
                ],
                [
                    'training_id' => 3,
                    'attribute' => [
                        'distance' => null,
                        'time' => 30,
                        'speed' => '44',
                        'unit_speed' => 'km',
                        'set' => 4,
                        'each_set' => 10,
                        'time_each_set' => 65
                    ]
                ]
            ]
        ],
        [
            'day_number' => 4,
            'training' => [
                [
                    'training_id' => 2,
                    'attribute' => [
                        'distance' => null,
                        'time' => 30,
                        'speed' => '44',
                        'unit_speed' => 'km',
                        'set' => 4,
                        'each_set' => 10,
                        'time_each_set' => 65
                    ]
                ],
                [
                    'training_id' => 3,
                    'attribute' => [
                        'distance' => null,
                        'time' => 30,
                        'speed' => '44',
                        'unit_speed' => 'km',
                        'set' => 4,
                        'each_set' => 10,
                        'time_each_set' => 65
                    ]
                ]
            ]
        ],
        [
            'day_number' => 5,
            'training' => [
                [
                    'training_id' => 2,
                    'attribute' => [
                        'distance' => null,
                        'time' => 30,
                        'speed' => '44',
                        'unit_speed' => 'km',
                        'set' => 4,
                        'each_set' => 10,
                        'time_each_set' => 65
                    ]
                ],
                [
                    'training_id' => 3,
                    'attribute' => [
                        'distance' => null,
                        'time' => 30,
                        'speed' => '44',
                        'unit_speed' => 'km',
                        'set' => 4,
                        'each_set' => 10,
                        'time_each_set' => 65
                    ]
                ]
            ]
        ],
        [
            'day_number' => 6,
            'training' => [
                [
                    'training_id' => 2,
                    'attribute' => [
                        'distance' => null,
                        'time' => 30,
                        'speed' => '44',
                        'unit_speed' => 'km',
                        'set' => 4,
                        'each_set' => 10,
                        'time_each_set' => 65
                    ]
                ],
                [
                    'training_id' => 3,
                    'attribute' => [
                        'distance' => null,
                        'time' => 30,
                        'speed' => '44',
                        'unit_speed' => 'km',
                        'set' => 4,
                        'each_set' => 10,
                        'time_each_set' => 65
                    ]
                ]
            ]
        ],


    ];

    $nutrition_perday = [
        'day_number' => 0,
        'meals' => [
            [

                'meal_id' => 1,
                'food_package_id' => 2,
                'energy' => 250,
                'unit' => 'gr',
                'size' => null,
                'time' => '08:00'

            ],
            [

                'meal_id' => 2,
                'food_package_id' => 2,
                'energy' => 250,
                'unit' => 'gr',
                'size' => null,
                'time' => '11:00'

            ],
            [

                'meal_id' => 3,
                'food_package_id' => 2,
                'energy' => 250,
                'unit' => 'gr',
                'size' => null,
                'time' => '13:00'

            ],
            [

                'meal_id' => 4,
                'food_package_id' => 2,
                'energy' => 250,
                'unit' => 'gr',
                'size' => null,
                'time' => '20:00'

            ]
        ]
    ];

    $perweek = [];
    for ($i = 0;$i <= 6 ; $i++) {
        $nutrition_perday['day_number'] = $i;
        array_push($perweek,$nutrition_perday);

    }

    $comp = [
        'trainings' => $training,
        'nutrition' => $perweek
    ];

    $programs = \App\Model\Programs::where('status','orphan')->get();
    foreach ($programs as $program) {
        $program->configuration = $comp;
        $program->save();
    }


});


Route::get('generate-calendar',function() {

    $programs = \App\Model\Programs::where('status','!=','orphan')->first();
    /*foreach ($programs as $program)
    {
        $nutrition = $program->configuration['nutrition'];
        $nutrition[0]['meals'][0]['familiar'] = [1,4];
        $nutrition[1]['meals'][2]['familiar'] = [4,6];
        $program->configuration = ['trainings' => $program->configuration['trainings'],'nutrition' => $nutrition];
        $program->save();

    }*/

    $generateCalendar = new \App\Helpers\GenerateCalendar();
    return $generateCalendar->generate($programs->id,1);

});





Route::get('fake_coaches',function () {
    $coach_role = \App\Model\Role::find(3);
    return $coaches = $coach_role->users;
});

Route::get('coaches',function() {
    $coach_role = \App\Model\Role::find(3);

    $coaches = [];
    foreach ($coach_role->users as $user) {
        $a_coach = [];

        $a_coach['id'] = $user->id;
        $a_coach['mobile'] = $user->mobile;

        $program = \App\Model\Programs::where('coach_id',$user->id)->get();
        if(count($program) > 0) {
            $a_coach['has_program'] = true;
        } else {
            $a_coach['has_program'] = false;
        }

        $conversations = \App\Model\Message::where('user_id',$user->id)->get();
        if(count($conversations) > 0) {
            $a_coach['has_conversation'] = true;
        } else {
            $a_coach['has_conversation'] = false;
        }
        array_push($coaches,$a_coach);
    }

    return $coaches;

});

Route::get('users',function () {

    $user_role = \App\Model\Role::find(2);
    $users = [];
    foreach ($user_role->users as $user) {

        $a_user = [];

        $a_user['id'] = $user->id;
        $a_user['mobile'] = $user->mobile;

        $program = \App\Model\Programs::where('user_id',$user->id)->get();
        if(count($program) > 0) {
            $a_user['has_program'] = true;
        } else {
            $a_user['has_program'] = false;
        }

        $conversations = \App\Model\Message::where('user_id',$user->id)->get();
        if(count($conversations) > 0) {
            $a_user['has_conversation'] = true;
        } else {
            $a_user['has_conversation'] = false;
        }

        $calendar = \App\Model\Calendar::where('user_id',$user->id)->get();
        if(count($calendar)) {

            $a_user['has_calendar'] = true;

        } else {
            $a_user['has_calendar'] = false;
        }
        array_push($users,$a_user);


    }

    return $users;

});

Route::get('/discount-code',function() {

    $promotions = \App\Model\Promotion::all(['code']);
    return $promotions;

});