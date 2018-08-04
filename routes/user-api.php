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

        Route::post('mobile','Api\User\AuthController@mobile');
        Route::post('login', 'Api\User\AuthController@login');
        Route::post('logout', 'Api\User\AuthController@logout');
        Route::post('refresh', 'Api\User\AuthController@refresh');
        Route::post('me', 'Api\User\AuthController@me');

    });
    Route::group(
        [
            'middleware' => ['jwtauth','UserRole'],
            'prefix' => 'user'
        ], function () {

        /* Profile User */
        Route::get('profile/','Api\User\ProfileController@index');
        Route::post('profile/store','Api\User\ProfileController@store');
        Route::post('profile/update','Api\User\ProfileController@update');
        Route::post('profile/avatar','Api\User\ProfileController@setAvatar');

        // Set & Get Step
        Route::post('/save-step','Api\User\ProfileController@saveStep');
        Route::get('/get-step','Api\User\ProfileController@getStep');

        /* Get Countries, States, Cities */
        Route::get('geo/countries','Api\User\GeoController@getAllCountries');
        Route::get('geo/countries/{id}','Api\User\GeoController@countryItem');
        Route::get('geo/states/{country_id}','Api\User\GeoController@getStates');
        Route::get('geo/cities/{state_id}','Api\User\GeoController@getCities');

        // Choose sport type
        Route::get('/choose-sport-type','Api\User\SportTypeController@index');

        // Choose Federation
        Route::get('/federations','Api\User\FederationController@index');
        Route::get('/federations/{federation_type}','Api\User\FederationController@show');

        // Choose Sport
        Route::get('/sports/{federation_id}','Api\User\SportController@show');

        // Accessories
        Route::get('/accessories','Api\User\AccessoriesController@index');
        Route::post('/accessories/store','Api\User\AccessoriesController@store');

        // Choose Coach
//        Route::get('/coachs/by_sportid/{id}','Api\User\CoachController@bySport');
        Route::get('/coachs/{coach_id}','Api\User\CoachController@show');
        Route::get('/coachs/filter/{sport_id}/','Api\User\CoachController@filter');
        //Route::get('/coachs/search/{keywords}/sport/{sport_id}','Api\User\CoachController@search');

        // Plans
        Route::get('plans/{plan_id}','Api\User\PlanController@show');
        Route::get('plans/by_sport/{sport_id}','Api\User\PlanController@bySportId');

        // Programs
        Route::post('programs/store','Api\User\ProgramsController@store');

        // Payment
        Route::get('payments/check/{reference}','Api\User\PaymentController@check');

    });

});

Route::get('login',function() {
   return 1;
})->name('login');

