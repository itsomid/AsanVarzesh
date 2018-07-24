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
    Route::group(
        [
            'middleware' => ['jwtauth','UserRole'],
            'prefix' => 'user'
        ], function () {

        /* Profile User */
        Route::get('profile/','Api\ProfileController@index');
        Route::post('profile/store','Api\ProfileController@store');
        Route::post('profile/update','Api\ProfileController@update');
        Route::post('profile/avatar','Api\ProfileController@setAvatar');

        // Set & Get Step
        Route::post('/save-step','Api\ProfileController@saveStep');
        Route::get('/get-step','Api\ProfileController@getStep');

        /* Get Countries, States, Cities */
        Route::get('geo/countries','Api\GeoController@getAllCountries');
        Route::get('geo/countries/{id}','Api\GeoController@countryItem');
        Route::get('geo/states/{country_id}','Api\GeoController@getStates');
        Route::get('geo/cities/{state_id}','Api\GeoController@getCities');

        // Choose sport type
        Route::get('/choose-sport-type','Api\SportTypeController@index');

        // Choose Federation
        Route::get('/federations','Api\FederationController@index');
        Route::get('/federations/{federation_type}','Api\FederationController@show');

        // Choose Sport
        Route::get('/sports/{federation_id}','Api\SportController@show');


        // Choose Coach
        Route::get('/coachs/search/{keywords}/sport/{sport_id}','Api\CoachController@search');
        Route::get('/coachs/{coach_id}','Api\CoachController@show');



    });

});

Route::get('login',function() {
   return 1;
})->name('login');
