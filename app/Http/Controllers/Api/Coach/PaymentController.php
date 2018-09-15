<?php

namespace App\Http\Controllers\Api\Coach;

use App\Model\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{

    public function index()
    {

        $user = auth('api')->user();
        $payments = Payment::with(['program.subscription','user'])->where('coach_id',$user->id)->orderby('id','DESC')->get();

        return response()->json($payments,200);

    }


}
