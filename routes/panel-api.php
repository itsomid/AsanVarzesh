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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => ['api'/*, 'cors'*/],'prefix' => '/v1'],function() {

    //Route::post('control-panel/auth/login','Api\Panel\AuthController@login');

    Route::group(['middleware' => 'api','prefix' => 'control-panel/auth'], function ($router) {

        Route::post('login', 'Api\Panel\AuthController@login');
        Route::post('logout', 'Api\Panel\AuthController@logout');
        Route::post('refresh', 'Api\User\AuthController@refresh');
        Route::post('me', 'Api\User\AuthController@me');

    });

    Route::get('geo/states/{country_id}','Api\User\GeoController@getStates');
    Route::get('geo/cities/{state_id}','Api\User\GeoController@getCities');

    Route::group(
        [
            'middleware' => ['jwtauth','AdminRole'],
            'prefix' => 'control-panel'
        ], function () {

            Route::get('/profile','Api\Panel\ProfileController@index');

            Route::get('/athletes','Api\Panel\AthletesController@index');
            Route::get('/athletes/{user_id}','Api\Panel\AthletesController@show');
            Route::post('/athletes/store','Api\Panel\AthletesController@store');
            Route::post('/athletes/update/{user_id}','Api\Panel\AthletesController@update');


            Route::get('/coaches','Api\Panel\CoachController@index');
            Route::get('/coaches/{coach_id}','Api\Panel\CoachController@show');
            Route::post('/coaches/store','Api\Panel\CoachController@store');
            Route::get('/coaches/{coach_id}/athletes','Api\Panel\CoachController@athletes');
            Route::get('/coaches/{coach_id}/payments','Api\Panel\CoachController@payments');
            Route::get('/coaches/{coach_id}/sports','Api\Panel\CoachController@sports');
            Route::get('/coaches/{coach_id}/programs/{status?}','Api\Panel\CoachController@programs');

            Route::get('/doctors/{role_id}','Api\Panel\DoctorController@index');
            Route::get('/doctors/{role_id}/{doctor_id}','Api\Panel\DoctorController@show');
            Route::post('/doctors/store','Api\Panel\DoctorController@store');
            Route::get('/doctors/{dr_id}/athletes','Api\Panel\DoctorController@athletes');

            Route::get('/requests','Api\Panel\RequestsController@index');
            Route::get('/requests/{program_id}','Api\Panel\RequestsController@show');
            Route::post('/requests/store','Api\Panel\RequestsController@store');

            Route::get('/sports','Api\Panel\SportsController@index');
            Route::post('/sports/store','Api\Panel\SportsController@store');

            Route::get('conversations','Api\Panel\ConversationsController@index');
            Route::get('conversations/unallowed-keywords','Api\Panel\ConversationsController@UnallowedKeywords');
            Route::get('conversations/search/{keyword}','Api\Panel\ConversationsController@search');

            Route::get('programs','Api\Panel\ProgramsController@index');
            Route::post('programs/store','Api\Panel\ProgramsController@store');

            Route::get('trainings','Api\Panel\TrainingsController@index');
            Route::post('trainings/store','Api\Panel\TrainingsController@store');


            Route::get('packages','Api\Panel\PackageController@index');
            Route::post('packages/store','Api\Panel\PackageController@store');

            Route::get('foods','Api\Panel\FoodController@index');
            Route::post('foods/store','Api\Panel\FoodController@store');


    }
    );

});


