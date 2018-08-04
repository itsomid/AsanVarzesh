<?php

namespace App\Http\Controllers\Api\User;

use App\Model\Coach_sport;
use App\Model\Payment;
use App\Model\Plan;
use App\Model\Programs;
use App\Model\Role;
use App\Model\Subscription;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgramsController extends Controller
{

    protected $assignment_capacity_for_doctor = 20;
    protected $assignment_capacity_for_corrective = 20;


    // Assign a User & a Coach to Program
    public function store(Request $request) {

        $user = auth('api')->user();
        $data = $request->all();

        $coach_sport = Coach_sport::where('sport_id',$data['sport_id'])->where('coach_id',$data['coach_id'])->first();
        $orphan_program = Programs::where('sport_id',$data['sport_id'])->where('status','orphan')->first();


        // Add Accessories




        // Add Program
        $program = new Programs();
        $program->user_id = $user->id;
        $program->coach_id = $data['coach_id'];
        $program->sport_id = $data['sport_id'];
        $program->doctor_id = $this->findDoctor();
        $program->corrective_doctor_id = $this->findcorrectiveDoctor();
        $program->start_date = $data['start_date'];
        $program->status = 'active';
        $program->configuration = $orphan_program->configuration;
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
        $subscription->coach_sport_id = $coach_sport->id;
        $subscription->save();


        // Add Payments
        $payment = new Payment();
        $payment->user_id = $user->id;
        $payment->subscription_id = $subscription->id;
        $payment->price = $coach_sport->price;
        $payment->via = 'zarinpal';
        $payment->type = 0;
        $payment->status = 'success';
        $reference = md5('ZarinPal-Test'.time());
        $payment->reference_id = $reference;
        if(isset($data['promotion_code'])) {

            // Todo: Add Promotion Model & find it by id
            $promotion_id = 1;
            $payment->promotion_id = $promotion_id;


        }
        $payment->save();

        $response_date = [
            'gateway_url' => 'http://zarinpal.com/gateway',
            'reference' => $reference
        ];

        return response($response_date,200);
        
    }

    public function findDoctor() {

        $doctors = Role::find(4);
        $doctors->users;
        foreach ($doctors->users as $user) {

            if(count($user->programs_as_doctor) <= $this->assignment_capacity_for_doctor) {
                return $user->id;
            }

        }
    }

    public function findcorrectiveDoctor() {

        $doctors = Role::find(5);
        $doctors->users;
        foreach ($doctors->users as $user) {

            if(count($user->programs_as_doctor) <= $this->assignment_capacity_for_doctor) {
                return $user->id;
            }

        }


    }
}
