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

Route::get('payment/cancel-payment/{id}',function ($id) {
   $payment = \App\Model\Payment::where('type','debit')->where('id',$id)->first();
   $payment->status = 'return';
   $payment->save();
});

Route::get('payment/debit/{payment_id}',function($payment_id) {
    $payment = \App\Model\Payment::find($payment_id);
    $program = \App\Model\Programs::find($payment->program_id);
    $coach = \App\User::find($program->coach_id);

    $debit_payment = new \App\Model\Payment();
    $debit_payment->user_id = $program->user_id;
    $debit_payment->coach_id = $program->coach_id;
    $debit_payment->corrective_doctor_id = $coach->team['corrective_doctor'];
    $debit_payment->nutrition_doctor_id = $coach->team['nutrition_doctor'];
    $debit_payment->federation_id = $program->sport->federation->id;
    $debit_payment->program_id = $program->id;
    //$debit_payment->subscription_id = $program->subscription_id;
    $debit_payment->price = $payment->price;
    $debit_payment->type = 'debit';
    $debit_payment->status = 'success';
    $debit_payment->promotion_id = null;
    $debit_payment->save();

    $program->status = 'pending';
    $program->save();
});

Route::get('/payment/{id}',function($id) {

    $last_payment = \App\Model\Payment::where('type','debit')
                                        ->where('status','success')
                                        ->where('user_id',$id)
                                        ->orderby('id','DESC')
                                        ->where('created_at','>',\Carbon\Carbon::now()->subYear(1))
                                        ->first();


    if(!$last_payment) {
        return 1;
    }



});



Route::get('/test',function (\Illuminate\Http\Request $request) {
    $coach= \App\User::find(11);
    return $coach->team['nutrition_doctor'];
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

