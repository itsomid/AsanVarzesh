<?php

namespace App\Http\Controllers\Api;

use App\Model\Payment;
use App\Model\Plan;
use App\Model\Programs;
use App\Model\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgramsController extends Controller
{

    // Assign a User & a Coach to Program
    public function store(Request $request) {

        $user = auth('api')->user();
        $data = $request->all();


        // Selected Plan
        $plan = Plan::find($data['plan_id']);


        // Add Program
        $program = new Programs();
        $program->user_id = $user->id;
        $program->coach_id = $data['coach_id'];
        $program->sport_id = $data['sport_id'];
        $program->start_date = $data['start_date'];
        $program->save();

        // Add Subscription

        $start_date = explode('-',$data['start_date']);
        $from = Carbon::create($start_date[0],$start_date[1],$start_date[2])->format('Y-m-d H:i:s');
        $to = Carbon::create($start_date[0],$start_date[1],$start_date[2])->addDay('30');

        $subscription = new Subscription();
        $subscription->user_id = $user->id;
        $subscription->from = $from;
        $subscription->to = $to;
        $subscription->program_id = $program->id;
        $subscription->plan_id = $data['plan_id'];
        $subscription->save();


        // Add Payments

        $payment = new Payment();
        $payment->user_id = $user->id;
        $payment->subscription_id = $subscription->id;
        $payment->price = $plan->price;
        $payment->via = 'zarinpal';
        $payment->type = 0;
        $payment->status = 'pending';
        $payment->reference_id = '';
        if(isset($data['promotion_code'])) {

            // Todo: Add Promotion Model & find it by id
            $promotion_id = 1;
            $payment->promotion_id = $promotion_id;

        }
        $payment->save();

        // Todo Set Reference Payment
        // Todo: Change Payment


        $response_date = [
            'payment_url' => url('payment'),
            'gateway_url' => 'http://pal.com/'
        ];

        return response($response_date,200);
        
    }
}
