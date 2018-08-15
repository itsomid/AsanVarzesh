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
