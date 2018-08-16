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

Route::get('fake',function() {

    $coach_role = \App\Model\Role::find(3);
    return $coaches = $coach_role->users;

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

Route::get('default-program',function () {

    $training = [
        [
            'day_number' => 0,
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
            'day_number' => 1,
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
            'day_number' => 2,
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
            'day_number' => 3,
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
            'day_number' => 4,
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
            'day_number' => 5,
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
            'day_number' => 6,
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


    return [
        'trainings' => $training,
        'nutrition' => $perweek
    ];

});