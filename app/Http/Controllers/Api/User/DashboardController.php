<?php

namespace App\Http\Controllers\Api\User;

use App\Model\Calendar;
use App\Model\Programs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index($date = null) {

        $user = auth('api')->user();

        if($date == null) {
            $date_carbon = Carbon::today();
        } else {
            $date_carbon = Carbon::parse($date);
        }
        
        $date = $date_carbon->format('Y-m-d').' 00:00:00';

        $programs = Programs::with('sport')->where('status','active')->where('user_id',$user->id)->orderby('id','DESC')->get()->toArray();

        $all_trainings_by_sport = [];
        foreach ($programs as $program)
        {

            if($date >= $program['start_date']) {
                $calendar_trainings = Calendar::where('user_id',$user->id)
                    ->with(['training.accessories','training.sport'])
                    ->where('type','training')
                    ->where('meal_id','=',null)
                    ->where('training_id','!=',null)
                    ->where('date',$date)
                    ->where('program_id',$program['id'])
                    ->orderby('id','DESC')
                    ->get()
                    ->toArray();
                $program['sport']['trainings'] = $calendar_trainings;
                array_push($all_trainings_by_sport,$program['sport']);
            } else {

                $program['sport'] = [];
                array_push($all_trainings_by_sport,$program['sport']);

            }

        }

        $calendar_nutrition = Calendar::where('user_id',$user->id)
            ->with(['meal'/*,'package.foods'*/,'package.foods'])
            ->where('type','package')
            //->where('package_id','!=',null)
            ->where('training_id','=',null)
            ->where('meal_id','!=',null)
            ->where('date',$date)
            ->orderby('id','DESC')
            ->get()
            ->toArray();

        $arr_training = $all_trainings_by_sport;
        //array_push($arr_training,$all_trainings_by_sport);

        $arr_nutrition = $calendar_nutrition;
        //array_push($arr_nutrition,$calendar_nutrition);

        return response()->json(
            [
                'trainings' => $arr_training,
                'nutrition' => $arr_nutrition
            ],
        200
        );


    }
}
