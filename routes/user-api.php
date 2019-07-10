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
        'prefix' => 'user/auth'

    ], function ($router) {

        Route::post('mobile','Api\User\AuthController@mobile');
        Route::post('login', 'Api\User\AuthController@login');
        Route::post('logout', 'Api\User\AuthController@logout');
        Route::post('refresh', 'Api\User\AuthController@refresh');
        Route::post('me', 'Api\User\AuthController@me');

    });

        /* Get Countries, States, Cities */
//        Route::get('/user/geo/countries','Api\User\GeoController@index');
        Route::get('/user/geo/countries','Api\User\GeoController@getAllCountries');
        Route::get('/user/geo/countries/{id}','Api\User\GeoController@countryItem');
        Route::get('/user/geo/states/{country_id}','Api\User\GeoController@getStates');
        Route::get('/user/geo/cities/{state_id?}','Api\User\GeoController@getCities');

        Route::get('user/payments/pay/{program_id}','Api\User\PaymentController@pay');
        Route::get('user/payments/check/{reference}','Api\User\PaymentController@check');
        Route::post('user/payments/callback/','Api\User\PaymentController@callback');
        Route::get('user/payments/verify/{reference_id}','Api\User\PaymentController@verifyPayment');

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
        Route::get('/coaches/{coach_id}','Api\User\CoachController@show');
        Route::get('/coaches/filter/{sport_id}/','Api\User\CoachController@filter');
        //Route::get('/coachs/search/{keywords}/sport/{sport_id}','Api\User\CoachController@search');

        // Plans
        Route::get('plans/{plan_id}','Api\User\PlanController@show');
        Route::get('plans/by_sport/{sport_id}','Api\User\PlanController@bySportId');



        // Programs
        Route::get('programs/','Api\User\ProgramsController@index');
        Route::get('programs/{id}/calendar','Api\User\ProgramsController@calendar');
        Route::post('programs/factor','Api\User\ProgramsController@programFactor');
        Route::post('programs/store','Api\User\ProgramsController@store');

        Route::get('activities','Api\User\ActivityController@index');
        Route::post('activities/store','Api\User\ActivityController@store');

        // Motivate
        Route::get('motivational/random','Api\User\MotivationalController@random');

        // Payment
        Route::get('payments','Api\User\PaymentController@index');

        Route::group(['middleware' => ['checkSubscription']], function () {

            // Calendars
            //Route::get('calendars/','Api\User\CalendarController@index');
            Route::post('calendars/update','Api\User\CalendarController@update');

            // Dashboard
            Route::get('dashboard/{date?}','Api\User\DashboardController@index');

            // Conversations
            Route::get('conversations','Api\User\ConversationController@index');
            Route::post('conversations/create','Api\User\ConversationController@createConversation');
            Route::get('conversations/show-messages/{conversation_id}','Api\User\ConversationController@showMessages');
            Route::post('conversations/send-message/','Api\User\ConversationController@sendMessage');
            Route::post('conversations/read/','Api\User\ConversationController@readConversation');
            Route::post('conversations/message/read/','Api\Coach\ConversationController@readMessage');

        });


    });

});

Route::get('login',function() {
   return 1;
})->name('login');

