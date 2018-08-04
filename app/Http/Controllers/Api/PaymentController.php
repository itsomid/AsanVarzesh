<?php

namespace App\Http\Controllers\Api;

use App\Model\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function check($reference) {

        $payment = Payment::where('reference_id',$reference)->first();

        return response()->json($payment,200);

    }
}
