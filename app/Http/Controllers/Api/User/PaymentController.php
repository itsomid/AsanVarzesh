<?php

namespace App\Http\Controllers\Api\User;

use App\Model\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{

    public function index()
    {
        $user = auth('api')->user();
        $payments = Payment::with(['program.subscription','coach'])->where('user_id',$user->id)->orderby('id','DESC')->get();
        return response()->json($payments,200);

    }
    public function check($reference) {

        $payment = Payment::where('reference_id',$reference)->first();
        return response()->json($payment,200);

    }

    public function callback() {



    }

    public function Increase() {

    }



}
