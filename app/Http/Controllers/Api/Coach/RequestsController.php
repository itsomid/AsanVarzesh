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

        $programs = Programs::where('status','orphan')->get();

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
        $programs = Programs::with('user.profile','sport')->where('coach_id',$coach->id)->where('status','pending')->orderby('id','DESC')->get();

        return $programs;
    }


    public function show($program_id)
    {

        $response_json = [
            "id" => 6,
            "start_date" => '2018-09-09',
            "weight" => 90,
            "abdominal" => 60,
            "arm" => 35,
            "wrist" => 45,
            "hip" => 70,
            "waist" => 60,
            "place_for_sport" => 'منزل',
            "time_of_exercises" => [
                [
                    'day_number' => 0,
                    'enable' => true,
                    'time' => '8-11'
                ],
                [
                    'day_number' => 1,
                    'enable' => true,
                    'time' => '8-11'
                ],
                [
                    'day_number' => 2,
                    'enable' => true,
                    'time' => '8-11'
                ],
                [
                    'day_number' => 3,
                    'enable' => true,
                    'time' => '8-11'
                ],
                [
                    'day_number' => 4,
                    'enable' => true,
                    'time' => '8-11'
                ],
                [
                    'day_number' => 5,
                    'enable' => true,
                    'time' => '8-11'
                ],
                [
                    'day_number' => 6,
                    'enable' => true,
                    'time' => '8-11'
                ]
            ],
            "level" => "amateur",
            "target" => 'تناسب اندام',
            "description" => 'توضیحات',
            "user" => [
                "id" => 5,
                "email" => null,
                "mobile" => "09178465144",
                "code" => 0,
                "permissions" => null,
                "steps" => "login_register",
                "status" => "active",
                "referal_code" => null,
                "referer_id" => null,
                "last_login" => null,
                "profile"  => [
                    "id" => 5,
                    "user_id" => 5,
                    "first_name" => "طهمورث",
                    "last_name" => "گل",
                    "text" => null,
                    "covered_area" => "گیشا - شهرآرا - ستارخان",
                    "avatar" => "http://cdn.isna.ir/d/2016/06/20/3/57306107.jpg",
                    "photos"  => [
                        "http://cdn.isna.ir/d/2016/06/20/3/57306107.jpg",
                        "https://www.tarafdari.com/sites/default/files/contents/user241416/content-note/mhrb-ftmy.jpg"
                    ],
                    "height"  => null,
                    "blood_type"  => "O-",
                    "diseases"  => [
                        'بیماری 1',
                        'بیماری 2'
                    ],
                    "maim"  => [
                        ' قطع عضو 1',
                        'قطع عضو 2'
                    ],
                    "city_id" => 117,
                    "address" => "استان آذربایجان غربی خیابان حقیقی ساختمان سوسنک کد پستی 4672180822",
                    "keywords" => "طهمورث - گل - طهمورث گل",
                    "nutrition_info" => null,
                    "gender" => "male",
                    "birth_date" => '1987-09-09'
                ]
            ]

        ];

        //return $response_json;

        $coach = auth('api')->user();
        $programs = Programs::with('user.profile','sport')
            ->where('id',$program_id)
            ->where('coach_id',$coach->id)
            ->where('status','pending')
            ->orderby('id','DESC')
            ->first()->toArray();

        $nutrition_calendar = [];
        foreach ($programs['configuration']['nutrition'] as $perday) {
            $nutrition_perday = ['day_number' => '', 'meals' => []];
            $nutrition_perday['day_number'] = $perday['day_number'];

            foreach ($perday['meals'] as $meal) {
                $packages = [];
                foreach ($meal['familiar'] as $item) {
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

        $payment = $program->payment;

        if($status == 'reject' && $payment != null && $program->status != 'reject') {

            $credit_payment = new Payment();
            $credit_payment->user_id = $payment->user_id;
            $credit_payment->program_id = $payment->program_id;
            $credit_payment->coach_id = $payment->coach_id;
            $credit_payment->subscription_id = $payment->subscription_id;
            $credit_payment->price = $payment->price;
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
