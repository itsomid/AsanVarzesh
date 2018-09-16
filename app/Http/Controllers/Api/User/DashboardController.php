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
            $date_carbon = Carbon::today();
        } else {
            $date_carbon = Carbon::parse($date);
        }
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
