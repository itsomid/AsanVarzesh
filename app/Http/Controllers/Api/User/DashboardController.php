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


        $programs = Programs::with('sport')->where('user_id',$user->id)->orderby('id','DESC')->get()->toArray();

        $all_trainings_by_sport = [];
        foreach ($programs as $program)
        {
//            $program['sport']['trainings'] = [];
            $calendar_trainings = Calendar::where('user_id',$user->id)
                ->with(['training.accessories','training.sport'])
                ->where('type','training')
                ->where('date',$date_carbon)
                ->where('program_id',$program['id'])
                ->orderby('id','DESC')
                ->get()
                ->toArray();
            $program['sport']['trainings'] = $calendar_trainings;
            array_push($all_trainings_by_sport,$program['sport']);


        }

        $calendar_nutrition = Calendar::where('user_id',$user->id)
            ->with(['meal'/*,'package.foods'*/,'package.foods'])
            ->where('type','package')
            //->where('package_id','!=',null)
            ->where('training_id','=',null)
            ->where('date',$date_carbon)
            ->orderby('id','DESC')
            ->get()
            ->toArray();

        $arr_training = [];
        array_push($arr_training,$all_trainings_by_sport);

        $arr_nutrition = [];
        array_push($arr_nutrition,$calendar_nutrition);

        return response()->json([
            'trainings' => $arr_training,
            'nutrition' => $arr_nutrition],200);


    }
}
