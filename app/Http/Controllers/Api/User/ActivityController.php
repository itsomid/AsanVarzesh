<?php

namespace App\Http\Controllers\Api\User;

use App\Model\Activity;
use App\Model\Calendar;
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

        if($data['calendar_id'] != null) {

            $has_activity = Activity::where('calendar_id',$data['calendar_id'])->where('user_id',$user->id)->first();
            if($has_activity == null OR $has_activity == '' OR empty($has_activity) ) {
                if($data['calendar_id'] != null) {
                    $calendar = Calendar::find($data['calendar_id']);
                    $calendar->status = 'done';
                    $calendar->save();
                }

                if($calendar->type == 'training') {
                    $activity = new Activity();
                    $activity->user_id = $user->id;
                    $activity->distance = $data['distance'];
                    $activity->energy = $data['energy'];
                    $activity->time  = $data['time'];
                    $activity->speed = $data['speed'];
                    $activity->calendar_id = $data['calendar_id'];
                    $activity->save();
                }

                return response()->json(['message' => 'activity added'],200);

            } else {

                return response()->json(['message' => 'added before'],406);

            }

        } else {

            $activity = new Activity();
            $activity->user_id = $user->id;
            $activity->distance = $data['distance'];
            $activity->energy = $data['energy'];
            $activity->time  = $data['time'];
            $activity->speed = $data['speed'];
            $activity->calendar_id = $data['calendar_id'];
            $activity->save();

            return response()->json(['message' => 'activity added'],200);


        }



        return response()->json(['message' => 'activity added'],200);


    }
}
