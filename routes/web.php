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

Route::get('/','Web\WebController@index');
Route::get('/rules','Web\WebController@rules');

Route::get('/test',function (\Illuminate\Http\Request $request) {

    $date_carbon = \Carbon\Carbon::today();
//    $keywords = $request->keywords;
//    $capacity_full = $request->capacity_full;
//    $by_price = $request->price;
//    return $sports = \App\Model\Sport::with(['coaches.profile' =>
//        function($query) use ($keywords) {
//            ///$query->where('keywords','like','%'.$keywords.'%');
//        }])->where('id',2)->first();
//    $coaches = [];
//    foreach ($sports->coaches as $coach) {
//        if($coach['profile']) {
//            array_push($coaches,$coach->profile);
//        }
//    }
//    return response()->json($coaches,200);


    $keywords = $request->keywords;
    $capacity_full = $request->capacity_full;
    $by_price = $request->price;

    return $sports = \App\Model\Sport::with(['coaches.profile' =>
        function($query) use ($keywords) {

            $query->where('keywords','like','%'.$keywords.'%')
                ->orWhere('first_name','like','%'.$keywords.'%')
                ->orWhere('last_name','like','%'.$keywords.'%');

        }])->where('id',1)->first();

    $coaches = [];

    foreach ($sports->coaches as $coach) {
        if($coach['profile']) {
            array_push($coaches,$coach->profile);
        }
    }



    return response()->json($coaches,200);


});

