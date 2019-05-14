<?php

namespace App\Http\Controllers\Api\Coach;

use App\Model\Conversation;
use App\Model\FoodPackage;
use App\Model\Package;
use App\Model\Payment;
use App\Model\Programs;
use App\Model\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RequestsController extends Controller
{

    public function index() {

        $response_json = [];
        $coach = auth('api')->user();
        $programs = Programs::where('coach_id',$coach->id)->where('status','orphan')->get();

        foreach ($programs as $program) {
            $program = [
                'user' => [
                    'id' => 2,
                    'profile' => [
                        'first_name' => 'محمد',
                        'last_name' => 'ریاحی',
                        'avatar' => 'http://asanvarzesh.lhost/images/placeholder.png',
                        'birth_date' => '1987-09-09'
                    ]
                ],
                'sport' => [
                    'id' => $program->sport->id,
                    'title' => $program->sport->title,
                    'image' => 'http://asanvarzesh.lhost/images/placeholder.png',
                ],
                'weight' => 90,
                'abdominal' => 75,
                'arm' => 20,
                'wrist' => 65,
                'hip' => 80,
                'waist' => 80,
                'place_for_sport' => 'منزل',
                'time_of_exercises' => [
                    [
                        'day' => 0,
                        'enable' => true,
                        'time' => '8-11',
                    ],
                    [
                        'day' => 1,
                        'enable' => true,
                        'time' => '8-11',
                    ],
                    [
                        'day' => 2,
                        'enable' => true,
                        'time' => '8-11',
                    ],
                    [
                        'day' => 3,
                        'enable' => true,
                        'time' => '8-11',
                    ],
                    [
                        'day' => 4,
                        'enable' => true,
                        'time' => '8-11',
                    ],
                    [
                        'day' => 5,
                        'enable' => true,
                        'time' => '8-11',
                    ],
                    [
                        'day' => 6,
                        'enable' => true,
                        'time' => '8-11',
                    ]

                ],
                'level' => 'amateur',
                'target' => 'کاهش وزن',

            ];

            array_push($response_json,$program);

        }


//        return $response_json;

        $coach = auth('api')->user();
        $field = $coach->getField();
        $programs = Programs::with('user.profile','sport')->where($field,$coach->id)->where('status','pending')->orderby('id','DESC')->get();

        return $programs;
    }


    public function show($program_id)
    {

        $coach = auth('api')->user();
        $field = $coach->getField();

        $programs = Programs::with('user.profile','sport')
            ->where('id',$program_id)
            ->where($field,$coach->id)
            ->where('status','pending')
            ->orderby('id','DESC')
            ->first()->toArray();

        $nutrition_calendar = [];
        foreach ($programs['configuration']['nutrition'] as $perday) {
            $nutrition_perday = ['day_number' => '', 'meals' => []];
            $nutrition_perday['day_number'] = $perday['day_number'];

            foreach ($perday['meals'] as $meal) {
                $packages = [];
                foreach ($meal['package'] as $item) {
                    $food_package = Package::with('foods')->where('id',$item)->first()->toArray();
                    array_push($packages,$food_package);
                }

                array_push($nutrition_perday['meals'],$packages);
            }

            array_push($nutrition_calendar,$nutrition_perday);
        }


        $programs['configuration']['nutrition'] = $nutrition_calendar;

        return $programs;

    }

    public function update($program_id,$status,Request $request) {


        $data = $request->all();
        $program = Programs::with('subscription','payment')->where('id',$program_id)->first();

        if($status == 'reject' && $program->payment != null && $program->status != 'reject') {

            $credit_payment = new Payment();
            $credit_payment->user_id = $program->payment->user_id;
            $credit_payment->program_id = $program->payment->program_id;
            $credit_payment->coach_id = $program->payment->coach_id;
            $credit_payment->subscription_id = $program->payment->subscription_id;
            $credit_payment->price = $program->payment->price;
            $credit_payment->type = 'credit';
            $credit_payment->status = 'return';
            $credit_payment->save();

            $subscription = Subscription::find($program->subscription_id);
            $subscription->delete();


            $program->status = $status;
            $program->text = $data['text'];
            $program->save();

            return response()->json([
                'message' => 'برنامه رد شد و هزینه دریافتی به کیف پول کاربر اضافه شد',
                'status' => 200
            ],200);


        } elseif($program->status == 'pending' && $status == 'accept') {

            $program->status = $status;
            $program->text = $data['text'];
            $program->save();

            $generateCalendar = new \App\Helpers\GenerateCalendar();
            $generateCalendar->generate($program->id,1);

            return response()->json([
                'message' => 'کلیت برنامه مورد نظر انجام شد',
                'status' => 200
            ],200);



        } else {
            return response()->json([
                'message' => 'وضعیت این برنامه قبلا مشخص شده است',
                'status' => 200
            ],200);
        }




    }
}
