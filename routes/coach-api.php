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
            Route::get('users/profile/{user_id}/diet','Api\Coach\UserProfileController@diet');
            Route::get('users/profile/{user_id}/training','Api\Coach\UserProfileController@trainings');

            // User Calendar ( Show Program Calendar by Selected Times & Day & Its Update)
            Route::get('users/calendar/trainings/{program_id}','Api\Coach\UserCalendarTrainingsController@showTrainings');
            Route::post('users/calendar/trainings/update','Api\Coach\UserCalendarTrainingsController@updateTrainings');
            Route::post('users/calendar/trainings/item/update','Api\Coach\UserCalendarTrainingsController@updateItem');
            Route::post('users/calendar/trainings/item/create','Api\Coach\UserCalendarTrainingsController@createItem');

            Route::get('users/calendar/meals/{program_id}','Api\Coach\UserCalendarMealsController@showMeals');
            Route::post('users/calendar/meals/update','Api\Coach\UserCalendarMealsController@updateMeals');
            Route::post('users/calendar/meals/item/update','Api\Coach\UserCalendarMealsController@updateItem');
            Route::post('users/calendar/meals/item/create','Api\Coach\UserCalendarMealsController@createItem');

            // Delete Calendar Item
            Route::post('users/calendar/item/delete','Api\Coach\UserCalendarTrainingsController@deleteItem');


        // Requests
            Route::get('requests','Api\Coach\RequestsController@index');
            Route::get('requests/{id}','Api\Coach\RequestsController@show');
            Route::post('requests/{program_id}/{status}','Api\Coach\RequestsController@update');


            // Coach Profile
            Route::get('profile','Api\Coach\ProfileController@index');
            Route::get('profile/team/{program_id?}','Api\Coach\ProfileController@team');
            Route::get('profile/basket','Api\Coach\ProfileController@basket');
            Route::post('profile/add-to-basket','Api\Coach\ProfileController@addtoBasket');
            Route::post('profile/upload-photo','Api\Coach\ProfileController@uploadImage');
            Route::post('profile/remove-photo','Api\Coach\ProfileController@removeImage');
            Route::post('profile/upload-avatar','Api\Coach\ProfileController@setAvatar');


        // Conversations
            Route::get('conversations','Api\Coach\ConversationController@index');
            Route::post('conversations/create','Api\Coach\ConversationController@createConversation');
            Route::get('conversations/show-messages/{conversation_id}','Api\Coach\ConversationController@showMessages');
            Route::post('conversations/send-message/','Api\Coach\ConversationController@sendMessage');
            Route::post('conversations/read/','Api\Coach\ConversationController@readConversation');
            Route::post('conversations/message/read/','Api\Coach\ConversationController@readMessage');

            // Programs
            Route::get('programs/{id}','Api\Coach\ProgramController@show');

            // Packages
            Route::get('packages','Api\Coach\PackageController@index');
            Route::get('packages/{id}','Api\Coach\PackageController@show');
            Route::get('packages/foods/all','Api\Coach\PackageController@foods');
            Route::get('packages/meals/all','Api\Coach\PackageController@meals');
            Route::post('packages/store','Api\Coach\PackageController@store');
            Route::post('packages/add-to-package','Api\Coach\PackageController@AddtoBasket');
            Route::get('packages/basket/all','Api\Coach\PackageController@packageBasket');


            // Payments
            Route::get('payments','Api\Coach\PaymentController@index');

            // Trainings
            Route::get('trainings/{sport_id}','Api\Coach\TrainingController@trainings');

            // Description Day
            Route::get('description-days/{program_id}/{day_number}','Api\Coach\DescriptionController@show');
            Route::post('description-days/','Api\Coach\DescriptionController@store');
            Route::post('description-days/{description_id}','Api\Coach\DescriptionController@update');

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

