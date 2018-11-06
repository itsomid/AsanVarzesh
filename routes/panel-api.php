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

    Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {

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




        }
    );

});


