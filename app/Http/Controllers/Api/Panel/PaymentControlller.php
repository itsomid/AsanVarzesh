<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentControlller extends Controller
{
    public function index() {
        $payments = Payment::with('subscription','user.profile.city','program.sport')
            ->where('user_id','!=','')
            ->orderby('id','DESC')
            ->paginate(10);
        return $payments;
    }
}
