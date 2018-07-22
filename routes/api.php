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

    Route::group([
        'middleware' => 'api',
        'prefix' => 'auth'

    ], function ($router) {

        Route::post('mobile','Api\AuthController@mobile');
        Route::post('login', 'Api\AuthController@login');
        Route::post('logout', 'Api\AuthController@logout');
        Route::post('refresh', 'Api\AuthController@refresh');
        Route::post('me', 'Api\AuthController@me');

    });
    Route::group(['middleware' => ['jwtauth','UserRole']], function () {

        /* Profile User */
        Route::get('profile/','Api\ProfileController@index');
        Route::post('profile/store','Api\ProfileController@store');
        Route::post('profile/update','Api\ProfileController@update');
        Route::post('profile/avatar','Api\ProfileController@setAvatar');

        /* Get Countries, States, Cities */
        Route::get('geo/countries','Api\GeoController@getAllCountries');
        Route::get('geo/states/{country_id}','Api\GeoController@getStates');
        Route::get('geo/cities/{state_id}','Api\GeoController@getCities');

        // Coachs

    });

});

Route::get('login',function() {
   return 1;
})->name('login');
