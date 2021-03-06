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

    Route::group(['middleware' => 'api','prefix' => 'control-panel/auth'], function ($router) {

        Route::post('login', 'Api\Panel\AuthController@login');
        Route::post('forget-password', 'Api\Panel\AuthController@forgetPassword');
        Route::post('logout', 'Api\Panel\AuthController@logout');
        Route::post('refresh', 'Api\User\AuthController@refresh');
        Route::post('me', 'Api\User\AuthController@me');



    });

    Route::get('geo/states/{country_id}','Api\Panel\GeoController@getStates');
    Route::get('geo/cities/{state_id?}','Api\Panel\GeoController@getCities');



    Route::group(
        [
            'middleware' => ['jwtauth','AdminRole','OperatorRole'],
            'prefix' => 'control-panel'
        ], function () {

            Route::get('dashboard','Api\Panel\DashboardController@index');

            Route::get('/profile','Api\Panel\ProfileController@index');

            Route::get('/people/','Api\Panel\PeopleController@index');
            Route::get('/people/{user_id}','Api\Panel\PeopleController@show');
            Route::post('/people/update/{user_id}','Api\Panel\PeopleController@update');
            Route::post('/people/store','Api\Panel\PeopleController@store');

            Route::get('/athletes','Api\Panel\AthletesController@index');
            Route::get('/athletes/{user_id}','Api\Panel\AthletesController@show');
            Route::post('/athletes/store','Api\Panel\AthletesController@store');
            Route::post('/athletes/update/{user_id}','Api\Panel\AthletesController@update');

            Route::get('/admins','Api\Panel\AdminController@index');
            Route::get('/admins/{admin_id}','Api\Panel\AdminController@show');
            Route::post('/admins/store','Api\Panel\AdminController@store');
            Route::post('/admins/update/{admin_id}','Api\Panel\AdminController@update');

            Route::get('/coaches','Api\Panel\CoachController@index');
            Route::get('/coaches/{coach_id}','Api\Panel\CoachController@show');
            Route::post('/coaches/store','Api\Panel\CoachController@store');
            Route::post('/coaches/update/{user_id}','Api\Panel\CoachController@update');
            Route::get('/coaches/{coach_id}/athletes','Api\Panel\CoachController@athletes');
            Route::get('/coaches/{coach_id}/payments','Api\Panel\CoachController@payments');
            Route::get('/coaches/{coach_id}/sports','Api\Panel\CoachController@sports');
            Route::get('/coaches/{coach_id}/programs/{status?}','Api\Panel\CoachController@programs');
            Route::post('/coaches/{coach_id}/upload-photo','Api\Panel\CoachController@uploadPhoto');


            Route::get('/doctors/{role_id}','Api\Panel\DoctorController@index');
            Route::get('/doctors/{role_id}/{doctor_id}','Api\Panel\DoctorController@show');
            Route::post('/doctors/store','Api\Panel\DoctorController@store');
            Route::get('/doctors/{dr_id}/athletes','Api\Panel\DoctorController@athletes');

            Route::get('/requests','Api\Panel\RequestsController@index');
            Route::get('/requests/{program_id}','Api\Panel\RequestsController@show');
            Route::post('/requests/store','Api\Panel\RequestsController@store');

            Route::get('/sports','Api\Panel\SportsController@index');
            Route::get('/sports/{id}','Api\Panel\SportsController@show');
            Route::post('/sports/{id}/update','Api\Panel\SportsController@update');
            Route::get('/federations','Api\Panel\SportsController@federations');
            Route::post('/sports/store','Api\Panel\SportsController@store');


            Route::get('/federations/all','Api\Panel\FederationController@index');
            Route::get('/federations/{id}','Api\Panel\FederationController@show');
            Route::post('/federations/store','Api\Panel\FederationController@store');
            Route::post('/federations/update/{id}','Api\Panel\FederationController@update');

            Route::get('conversations','Api\Panel\ConversationsController@index');
            Route::get('conversations/{id}','Api\Panel\ConversationsController@show');
            Route::get('conversations/unallowed-keywords','Api\Panel\ConversationsController@UnallowedKeywords');
            Route::get('conversations/actions/search','Api\Panel\ConversationsController@search');

            Route::get('programs','Api\Panel\ProgramsController@index');
            Route::post('programs/store','Api\Panel\ProgramsController@store');

            Route::get('trainings','Api\Panel\TrainingsController@index');
            Route::get('trainings/{id}','Api\Panel\TrainingsController@show');
            Route::post('trainings/store','Api\Panel\TrainingsController@store');
            Route::post('trainings/{id}','Api\Panel\TrainingsController@update');

            Route::get('meals','Api\Panel\MealsController@index');
            Route::post('meals/store','Api\Panel\MealsController@store');
            Route::post('meals/delete/{meal_id}','Api\Panel\MealsController@delete');

            Route::get('packages','Api\Panel\PackageController@index');
            Route::get('packages/{id}','Api\Panel\PackageController@show');
            Route::post('packages/update/{id}','Api\Panel\PackageController@update');
            Route::post('packages/store','Api\Panel\PackageController@store');

            Route::get('foods','Api\Panel\FoodController@index');
            Route::get('foods/category','Api\Panel\FoodController@category');
            Route::get('foods/{id}','Api\Panel\FoodController@show');
            Route::post('foods/update/{id}','Api\Panel\FoodController@update');
            Route::post('foods/store','Api\Panel\FoodController@store');

            Route::get('motivisionals','Api\Panel\MotivisionalController@index');
            Route::post('motivisionals/store','Api\Panel\MotivisionalController@store');
            Route::post('motivisionals/delete/{id}','Api\Panel\MotivisionalController@delete');


            Route::get('accessories','Api\Panel\AccessoryController@index');
            Route::get('accessories/{id}','Api\Panel\AccessoryController@show');
            Route::post('accessories/store','Api\Panel\AccessoryController@store');
            Route::post('accessories/update/{id}','Api\Panel\AccessoryController@update');


            Route::get('settings','Api\Panel\SettingController@index');
            Route::post('settings/store','Api\Panel\SettingController@store');

            Route::get('payments','Api\Panel\PaymentControlller@index');


    }
    );

});


