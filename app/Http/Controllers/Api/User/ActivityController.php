<?php

namespace App\Http\Controllers\Api\User;

use App\Model\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
    public function index() {

        $user = auth('api')->user();

        $activities = Activity::where('user_id',$user->id)->orderby('id','DESC')->get();

        return response()->json($activities,200);

    }

    public function store(Request $request) {

        $user = auth('api')->user();

        $data = $request->all();

        $activity = new Activity();
        $activity->user_id = $user->id;
        $activity->distance = $data['distance'];
        $activity->calorie = $data['calorie'];
        $activity->time  = $data['time'];
        $activity->calendar_id = $data['calendar_id'];
        $activity->save();

        return response()->json(['message' => 'activity added'],200);


    }
}
