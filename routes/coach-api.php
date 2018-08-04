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

            Route::get('dashboard/{status?}','Api\Coach\DashboardController@index');

            // Profile User
            Route::get('profile/{user_id}','Api\Coach\ProfileController@show');

            // Program
            Route::get('programs/{program_id}','Api\Coach\ProgramController@show');

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

