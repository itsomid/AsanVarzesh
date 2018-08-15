<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => '/v1'],function() {

    Route::group([
        'middleware' => 'api',
        'prefix' => 'coach/auth'

    ], function ($router) {

        Route::post('mobile','Api\Coach\AuthController@mobile');
        Route::post('login', 'Api\Coach\AuthController@login');
        Route::post('logout', 'Api\Coach\AuthController@logout');
        Route::post('refresh', 'Api\Coach\AuthController@refresh');
        Route::post('me', 'Api\Coach\AuthController@me');

    });
    Route::group(
        [
            'middleware' => ['jwtauth','CoachRole'],
            'prefix' => 'coach'
        ], function () {

            Route::get('dashboard/{date?}','Api\Coach\DashboardController@index');

            // Training By User
            Route::get('user-training/{user_id}','Api\Coach\UserTrainingController@userTraining');

            // Users By Sport
            Route::get('users/sports','Api\Coach\SportTypeController@index');
            Route::get('users/sports/{sport_id}','Api\Coach\SportTypeController@show');

            // Users
            Route::get('users/profile/{user_id}','Api\Coach\UserProfileController@show');

            // Requests
            Route::get('requests','Api\Coach\RequestsController@index');


            // Coach Profile
            Route::get('profile','Api\Coach\ProfileController@index');

    });

});

Route::get('coaches-with-programs',function() {

    $programs = \App\Model\Programs::with('coach.profile')->where('coach_id','!=',0)->get();

    $mobiles = [];

    foreach ($programs as $program) {

        array_push($mobiles,$program->coach->mobile);

    }

    return $mobiles;

});

Route::get('login',function() {
   return 1;
})->name('login');

