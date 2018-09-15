<?php

namespace App\Http\Controllers\Api\User;

use App\Model\Calendar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index($date = null) {

        $user = auth('api')->user();

        if($date == null) {

            $calendar_trainings = Calendar::where('user_id',$user->id)
                ->with('training.accessories')
                ->where('type','training')
                ->orderby('id','DESC')
                ->get()
                ->groupBy('date')->toArray();
            reset($calendar_trainings);
            $key = key($calendar_trainings);

            $trainings = $calendar_trainings[$key]; /* Final */

            $calendar_nutrition = Calendar::where('user_id',$user->id)
                ->with('package.foods')
                ->where('type','package')
                ->orderby('id','DESC')
                ->get()
                ->groupBy('date')->toArray();
            reset($calendar_nutrition);
            $key = key($calendar_nutrition);

            $nutrition = $calendar_nutrition[$key]; /* Final */

            return response()->json([
                'trainings' => $trainings,
                'nutrition' => $nutrition],200);


        } else {
            $date_carbon = Carbon::parse($date);

            $calendar_trainings = Calendar::where('user_id',$user->id)
                ->with('training.accessories')
                ->where('type','training')
                ->where('date',$date_carbon)
                ->orderby('id','DESC')
                ->get()
                ->toArray();

            $calendar_nutrition = Calendar::where('user_id',$user->id)
                ->with('training.accessories')
                ->where('type','training')
                ->where('date',$date_carbon)
                ->orderby('id','DESC')
                ->get()
                ->toArray();

            return response()->json([
                'trainings' => $calendar_trainings,
                'nutrition' => $calendar_nutrition],200);

        }


    }
}
