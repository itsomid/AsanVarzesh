<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',function() {
   return 'index page';
});

Route::group(['middleware' => ['CheckAuth','UserRole']], function () {

    Route::get('/protect',function(){
        return '/protect';
    });

});

Route::get('fake',function() {

    $user = \App\User::find(21);

    $accessories = [1,2];

    $user->accessories()->attach($accessories);

});
