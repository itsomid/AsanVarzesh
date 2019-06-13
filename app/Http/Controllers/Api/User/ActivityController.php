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

            /* Based on Calendar */
            $calendar = Calendar::find($data['calendar_id']);
            $attributes = $calendar->attributes;

            if($calendar->type == 'training') {

                /* It's Training */
                $has_activity = Activity::where('calendar_id',$data['calendar_id'])->where('user_id',$user->id)->first();

                if($has_activity != null OR $has_activity != '' OR !empty($has_activity) ) {

                    /* This Training Added Before */
                    return response()->json(['message' => 'added before'],406);

                } else {

                    $activity = new Activity();
                    $activity->user_id = $user->id;
                    $activity->distance = $attributes['distance'];
                    $activity->energy = $attributes['energy'];
                    $activity->time  = $attributes['time'];
                    $activity->speed = $attributes['speed'];
                    $activity->unit_speed = $attributes['unit_speed'];
                    $activity->set = $attributes['set'];
                    $activity->each_set = $attributes['each_set'];
                    $activity->time_each_set = $attributes['time_each_set '];
                    $activity->calendar_id = $data['calendar_id'];
                    $activity->save();

                    // Update Calendar Status
                    $calendar->status = 'done';
                    $calendar->save();

                    return response()->json(['message' => 'activity added'],200);

                }

            } else {

                /* It's Package */
                if($calendar->used_package_id != null) {

                    // Added Before
                    return response()->json(['message' => 'added before'],406);

                } else {

                    // Add Package_id to calendar record item
                    $calendar->status = 'done';
                    $calendar->used_package_id = $data['package_id'];
                    $calendar->save();

                    return response()->json(['message' => 'activity added'],200);

                }

            }


        } else {

            /* It's Running */
            $activity = new Activity();
            $activity->user_id = $user->id;
            $activity->distance = $data['distance'];
            $activity->energy = $data['energy'];
            $activity->time  = $data['time'];
            $activity->speed = $data['speed'];
            $activity->calendar_id = null;
            $activity->save();

        }

        return response()->json(['message' => 'activity added'],200);


    }
}
