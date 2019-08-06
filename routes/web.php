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

Route::get('/','Web\WebController@index')->name('home');
Route::get('/coach','Web\WebController@coach')->name('coach');
Route::get('/experts','Web\WebController@experts')->name('experts');
Route::get('/specialists','Web\WebController@specialists')->name('specialists');
Route::get('/rules/coach','Web\WebController@ruleCoach')->name('rules/coach');
Route::get('/rules/asan-varzesh','Web\WebController@ruleAv')->name('rules/av');
Route::get('/rules/user','Web\WebController@ruleUser')->name('rules/user');

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

Route::get('user/{id}',function($id) {
   return \App\User::with('payments')->find($id);
});

Route::get('training',function(\App\Model\Payment $payment) {
    return \App\Model\Payment::$create_file;
    return \App\Model\Training::find(1);
});

Route::get('program/{id}',function ($id) {
    $program = \App\Model\Programs::find($id);
    $payment = \App\Model\Payment::where('type','debit')
    ->where('program_id',$program->id)
    ->first();
    $payment->status = 'failed';
    $payment->save();

    $credit_payment = new \App\Model\Payment();
    $credit_payment->user_id = $payment->user_id;
    $credit_payment->price = $payment->price;
    $credit_payment->type = 'credit';
    $credit_payment->status = 'return';
    $credit_payment->save();

});

Route::get('/test',function (\Illuminate\Http\Request $request) {

    $user = \App\User::find(5);
    return $user->getFieldProgram();

});

Route::get('/change-training-program/',function() {
   $programs = \App\Model\Programs::all();
   foreach ($programs as $program) {
       $program = \App\Model\Programs::find($program->id);
       $config = $program->configuration;
       foreach ($config['trainings'] as $key1 => $day) {
           foreach ($config['trainings'][$key1]['training'] as $key2 => $item) {
               $config['trainings'][$key1]['training'][$key2]['training_id'] = (string) 111;
           }
       }
       $program->configuration = $config;
       $program->save();
   }
});


Route::get('/generate-calendar/{id}',function($id) {
    $program = \App\Model\Programs::find($id);
    $generateCalendar = new \App\Helpers\GenerateCalendar();
    $generateCalendar->generate($program->id,1);
});

Route::get('/change-training-calendar',function() {
    $calendars = \App\Model\Calendar::where('training_id','<',111)->get();
    foreach ($calendars as $calendar) {
        $calendar->training_id = 111;
        $calendar->save();
    }
});