<?php

namespace App\Http\Controllers\Api\User;

use App\Activity;
use App\Model\Calendar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CalendarController extends Controller
{
    public function update(Request $request)
    {
        $user = auth('api')->user();
        $data = $request->all();

        $calendar = Calendar::find($data['calendar_item_id']);
        $calendar->status = $data['status'];
        $calendar->save();

        // Add Activity
        $activity = new Activity();
        $activity->user_id = $user->id;
        $activity->activities = $data['activities'];
        $activity->energy = $data['energy'];
        $activity->time = $data['time'];
        $activity->calendar_id = $calendar->id;
        $activity->save();

        return response()->json($activity,200);
    }


}
