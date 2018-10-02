<?php

namespace App\Http\Controllers\Api\User;

use App\Model\Calendar;
use App\Model\Coach_sport;
use App\Model\Payment;
use App\Model\Plan;
use App\Model\Programs;
use App\Model\Role;
use App\Model\Sport;
use App\Model\Subscription;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgramsController extends Controller
{

    protected $assignment_capacity_for_doctor = 20;
    protected $assignment_capacity_for_corrective = 20;

    public function index()
    {

        $user = auth('api')->user();

        $programs = Programs::with([
                                    'sport.trainings',
                                    'coach.profile',
                                    'corrective_doctor.profile',
                                    'nutrition_doctor.profile'
                                ])->where('user_id',$user->id)->orderby('id','DESC')->get();

        return response()->json($programs,200);

    }

    public function programFactor(Request $request) {

        $data = $request->all();

        $coach = User::find($data['coach_id']);

        $coach_price = Coach_sport::where('coach_id',$data['coach_id'])
                                    ->where('sport_id',$data['sport_id'])
                                    ->first();

        if($coach_price != null) {

            $response = [
                'coach_price' => $coach_price->price,
                'tax' => $coach_price->price * 0.09,
                'insurance' => 1000
            ];

            return response()->json($response,200);

        } else {

            return response()->json(['message' => 'not Found'],404);

        }

    }

    public function calendar($program_id)
    {

        $calendar_trainings = Calendar::with('training.accessories')
                                        ->where('type','training')
                                        ->where('program_id',$program_id)
                                        ->orderby('id','DESC')
                                        ->get()
                                        ->groupBy('date')->toArray();

        $calendar_nutrition = Calendar::with('package','familiar.foods')
            ->where('type','package')
            ->where('program_id',$program_id)
            ->orderby('id','DESC')
            ->get()
            ->groupBy('date')->toArray();

        return response()->json([
            'trainings' => $calendar_trainings,
            'nutrition' => $calendar_nutrition
        ],200);

    }

    // Assign a User & a Coach to Program
    public function store(Request $request) {

        $data = $request->all();
        $data['time_of_exercises'];
        $user = auth('api')->user();

        $coach_sport = Coach_sport::where('sport_id',$data['sport_id'])->where('coach_id',$data['coach_id'])->first();
        $orphan_program = Programs::where('sport_id',$data['sport_id'])->where('status','orphan')->first();
        $sport = Sport::with('federation')->find($data['sport_id']);
        $coach = User::find($data['coach_id']);

        if($data['trial'] == true) {
            $reference = 'trial';

            $to_days = 7;
            $price = 0;
            if($coach->trial == false) {
                return response()->json([
                    'message' => 'برای داشتن برنامه با این مربی مجاز به استفاده از نسخه Trial نیستید'
                ],400);
            }

        } else {
            $reference = md5(time()); /* Get Reference ID From Payment Gateway, It's Test Now */
            $to_days = 30;
            $coach_price = Coach_sport::where('coach_id',$data['coach_id'])
                ->where('sport_id',$data['sport_id'])
                ->first();
            $price = ($coach_price->price * 0.09) + 1000;
        }

        // Add Program
        $program = new Programs();
        $program->user_id = $user->id;
        $program->coach_id = $data['coach_id'];
        $program->sport_id = $data['sport_id'];
        $program->nutrition_doctor_id = $coach->team['nutrition_doctor'];
        $program->corrective_doctor_id = $coach->team['corrective_doctor'];
        $program->start_date = $data['start_date'];
        $program->status = 'pending';
        $program->time_of_exercises = $data['time_of_exercises'];
        $program->configuration = $orphan_program->configuration;
        $program->federation_id = $sport->federation->id;
        $program->target = $data['target'];
        $program->level = $data['level'];

        // Physical Information
        $program->weight = $data['weight'];
        $program->abdominal = $data['abdominal'];
        $program->arm = $data['arm'];
        $program->wrist = $data['wrist'];
        $program->hip = $data['hip'];
        $program->waist = $data['waist'];
        $program->place_for_sport = $data['place_for_sport'];
        $program->save();


        // Add Subscription
        $start_date = explode('-',$data['start_date']);
        $from = Carbon::create($start_date[0],$start_date[1],$start_date[2])->format('Y-m-d H:i:s');
        $to = Carbon::create($start_date[0],$start_date[1],$start_date[2])->addDay($to_days);

        $subscription = new Subscription();
        $subscription->user_id = $user->id;
        $subscription->from = $from;
        $subscription->to = $to;
        $subscription->program_id = $program->id;
        $subscription->coach_sport_id = $coach_sport->id;
        $subscription->save();
        $program->subscription_id = $subscription->id;
        $program->save();


        // Add Payments

        $payment = new \App\Model\Payment();
        $payment->user_id = $program->user_id;
        $payment->program_id = $program->id;
        $payment->coach_id = $program->coach_id;
        $payment->subscription_id = $program->subscription_id;
        $payment->price = $price;
        $payment->via = 'Iran Kish';
        $payment->status = 'success';
        $payment->reference_id = $reference;
        $payment->promotion_id = null;
        $payment->save();
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

}
