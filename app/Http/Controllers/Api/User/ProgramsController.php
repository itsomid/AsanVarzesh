<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\IranKish;
use App\Model\Calendar;
use App\Model\Coach_sport;
use App\Model\Payment;
use App\Model\Programs;
use App\Model\Promotion;
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

        $programs = Programs::with(['sport.trainings',
                                    'coach.profile',
                                    'corrective_doctor.profile',
                                    'nutrition_doctor.profile'])
            ->where('user_id',$user->id)

            ->orderby('id','DESC')
            ->get();

        return response()->json($programs,200);

    }

    public function programFactor(Request $request) {

        $data = $request->all();

        $coach = User::find($data['coach_id']);
        $user = auth('api')->user();

        $coach_price = Coach_sport::where('coach_id',$data['coach_id'])
                                    ->where('sport_id',$data['sport_id'])
                                    ->first();

        $discount = 0;
        if($data['discount_code'] != null) {
            $promotion = Promotion::where('code',$data['discount_code'])->first();
            if($promotion == null) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Not Found'
                ],404);
            }
            $discount = $promotion->apply($user->id,$promotion->code,$coach_price->price,$coach->id,$data['sport_id']);
            if($discount == false) {
                return response()->json(['status' => 406,'message' => 'discount code is not valid'],406);
            }
        }



        if($coach_price != null) {

            $response = [
                'coach_price' => $coach_price->price,
                'tax' => Payment::calTax($coach_price->price),
                'insurance' => Payment::insurance(),
                'discount' => $discount,
                'total' => Payment::calculatePrice($coach_price->price,$discount)
            ];

            return response()->json($response,200);

        } else {

            return response()->json(['message' => 'Not Found'],404);

        }

    }

    public function calendar($program_id)
    {

        $calendar_trainings = Calendar::with('training.accessories')
                                        ->where('type','training')
                                        ->where('program_id',$program_id)
                                        /*->where('training_id','!=',null)*/
                                        ->orderby('date','DESC')
                                        ->get()
                                        ->groupBy('date')->toArray();

        $calendar_trainings_arr = [];

        foreach ($calendar_trainings as $training) {
            array_push($calendar_trainings_arr,$training);
        }

        $calendar_nutrition = Calendar::with('package.foods','meal')
            ->where('type','package')
            ->where('program_id',$program_id)
            ->orderby('id','DESC')
            ->get()
            ->groupBy('date')->toArray();


        $calendar_nutrition_arr = [];
        foreach ($calendar_nutrition as $nutrition) {
            array_push($calendar_nutrition_arr,$nutrition);
        }

        return response()->json([
            'trainings' => $calendar_trainings_arr,
            'nutrition' => $calendar_nutrition_arr
        ],200);

    }

    // Assign a User & a Coach to Program
    public function store(Request $request) {

        $data = $request->all();

        $user = auth('api')->user();

        $check_prevs_programs = Programs::where('sport_id',$data['sport_id'])
                                                ->where('user_id',$user->id)
                                                //->whereIn('status',['accept','active','pending','awaiting_payment'])
                                                ->whereIn('status',['accept','active'])
                                                ->count();

        if($check_prevs_programs >= 1) {

            return response()->json(['message' => 'شما در این رشته ورزشی یک برنامه فعال دارید'],400);

        }


        $user->profile->appetite = $data['appetite'];
        $user->profile->budget = $data['budget'];
        $user->profile->military_services = $data['military_services'];
        $user->profile->height = $data['height'];
        $user->profile->weight = $data['weight'];
        $user->profile->abdominal = $data['abdominal'];
        $user->profile->arm = $data['arm'];
        $user->profile->wrist = $data['wrist'];
        $user->profile->hip = $data['hip'];
        $user->profile->waist = $data['waist'];
        $user->profile->foot_thighs = $data['foot_thighs'];
        $user->profile->ankle = $data['ankle'];
        $user->profile->chest = $data['chest'];
        $user->profile->shoulder = $data['shoulder'];
        $user->profile->forearm = $data['forearm'];
        $user->profile->save();


        $coach_sport = Coach_sport::where('sport_id',$data['sport_id'])->where('coach_id',$data['coach_id'])->first();
        $orphan_program = Programs::where('sport_id',$data['sport_id'])->orderby('id','DESC')->where('status','orphan')->first();
        $sport = Sport::with('federation')->find($data['sport_id']);
        $coach = User::find($data['coach_id']);

        if($data['trial'] === true) {
            $reference = 'trial';
            $to_days = 7;
            $price = 0;
            if($coach->trial == false) {
                return response()->json([
                    'message' => 'برای داشتن برنامه با این مربی مجاز به استفاده از نسخه Trial نیستید'
                ],400);
            }

        } else {
            $to_days = 30;
            $coach_price = Coach_sport::where('coach_id',$data['coach_id'])
                ->where('sport_id',$data['sport_id'])
                ->first();

            $discount = 0;
            if($data['discount_code'] != null) {
                $promotion = Promotion::where('code',$data['discount_code'])->first();
                if($promotion == null) {
                    return response()->json([
                        'status' => 404,
                        'message' => 'not found'
                    ],404);
                }
                $discount = $promotion->apply($user->id,$promotion->code,$coach_price->price,$coach->id,$data['sport_id']);
                if($discount == false) {
                    return response()->json(['status' => 406,'message' => 'discount code is not valid'],406);
                }
            }
            $price = Payment::calculatePrice($coach_price->price,$discount);

        }

        // Change Time of exercises
        $time_of_exercises = [];
        foreach ($data['time_of_exercises'] as $item) {
            $row = [
                'day_number' => intval($item['day_number']),
                'start_time' => $item['start_time'],
                'end_time' => $item['end_time'],
            ];

            array_push($time_of_exercises,$row);
        }


        // Last User Program
        $lastProgram = Programs::where('user_id',$user->id)->orderby('id','DESC')->first();
        $nutrition_doctor_id = $coach->team['nutrition_doctor'];
        $corrective_doctor_id = $coach->team['corrective_doctor'];
        if($lastProgram) {
            $nutrition_doctor_id = $lastProgram->nutrition_doctor_id;
            $corrective_doctor_id = $lastProgram->corrective_doctor_id;
        }


        // Add Program
        $program = new Programs();
        $program->user_id = $user->id;
        $program->coach_id = $data['coach_id'];
        $program->sport_id = $data['sport_id'];
        $program->nutrition_doctor_id = $nutrition_doctor_id;
        $program->corrective_doctor_id = $corrective_doctor_id;
        $program->start_date = Carbon::today();
        $program->status = 'awaiting_payment';
        $program->time_of_exercises = $time_of_exercises;
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
        $program->foot_thighs = $data['foot_thighs'];
        $program->ankle = $data['ankle'];
        $program->chest = $data['chest'];
        $program->shoulder = $data['shoulder'];
        $program->forearm = $data['forearm'];


        $program->sport_habits = $data['sport_habits'];
        $program->sport_desc = $data['sport_desc'];
        $program->nutrition_desc = $data['nutrition_desc'];
        $program->place_for_sport = $data['place_for_sport'];
        $program->save();

        // Add Subscription
        $start_date = explode('-',$data['start_date']);
        $from = Carbon::today()->format('Y-m-d H:i:s');
        $to = Carbon::today()->addDay($to_days);

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
        $payment->status = 'pending';
        $payment->promotion_id = null;
        $payment->save();

        if(isset($data['promotion_code'])) {
            // Todo: Add Promotion Model & find it by id
            $promotion_id = 1;
            $payment->promotion_id = $promotion_id;
        }
        $payment->save();

        if($data['trial'] !== true) {

            // Update Payment -- add reference to payment item
            $gateway = new IranKish();
            $token = $gateway->getToken($price*10,$program->id,$payment->id);
            $payment = Payment::find($payment->id);
            $payment->token = $token;
            $payment->save();
            $response_data = [
                'pay' => url('api/v1/user/payments/pay/'.$program->id),
                'trial' => false,
                'price' => $payment->price
            ];

        } else {
            $response_data = [
                'pay' => '',
                'trial' => true
            ];
        }
        return response($response_data,200);



        
    }

    

}
