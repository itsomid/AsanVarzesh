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

Route::group(['prefix' => '/v1'],function() {

    //Route::post('control-panel/auth/login','Api\Panel\AuthController@login');

    Route::group(['middleware' => 'api','prefix' => 'control-panel/auth'], function ($router) {

        Route::post('login', 'Api\Panel\AuthController@login');
        Route::post('logout', 'Api\Panel\AuthController@logout');
        Route::post('refresh', 'Api\User\AuthController@refresh');
        Route::post('me', 'Api\User\AuthController@me');

    });

    Route::group(
        [
            'middleware' => ['jwtauth','AdminRole'],
            'prefix' => 'control-panel'
        ], function () {


            Route::get('/athletes','Api\Panel\AthletesController@index');
            Route::get('/athletes/{user_id}','Api\Panel\AthletesController@show');
            Route::post('/athletes/create','Api\Panel\AthletesController@create');
            Route::get('/athletes/{user_id}/update','Api\Panel\AthletesController@create');


    }
    );

});


