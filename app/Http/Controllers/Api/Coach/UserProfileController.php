<?php

namespace App\Http\Controllers\Api\Coach;

use App\Model\Calendar;
use App\Model\Conversation_user;
use App\Model\Programs;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserProfileController extends Controller
{
    public function show($user_id)
    {

        $coach = auth('api')->user();
        $field = $coach->getField();

        $user = User::with([
            'profile.city',
            'activities',
            'active_programs.sport',
            'sport_by_coach' =>function($q){$q->with('sport');},
            ])->where('id',$user_id)->first();/*->toArray();*/

        $user_arr = $user->toArray();
        $user_arr['private_conversations'] = $coach->conversations()->where('type','private')->with(['user.profile','user.roles'])->get();
        $user_arr['group_conversations'] = $coach->conversations()->where('type','group')->with(['user.profile','user.roles'])->get();

        $program = Programs::where('user_id',$user_id)
                            ->where($field,$coach->id)
                            ->orderBy('id','DESC')
                            ->first();


        if($program) {

            $calendar = $program->calendar->groupBy('date')->toArray();
            reset($calendar);
            $first_day = key($calendar);

            end($calendar);
            $last_day = key($calendar);

            $user_arr['first_day'] = $first_day;
            $user_arr['last_day'] = $last_day;
            $user_arr['nutrition_calendar'] = $this->diet($user['id']);
            return $user_arr;
        } else {
            $user['nutrition_calendar'] = [];
            return $user_arr;

        }





    }

    public function diet($user_id) {

        $calendars = Calendar::where('user_id',$user_id)
            ->where('training_id','=',null)
            ->orderby('id','DESC')
            ->with(['training','meal','package.foods'])
            ->get()->groupBy('date');

        $transformed_calendars = [];

        foreach ($calendars as $calendar) {
            array_push($transformed_calendars,$calendar);

        }

        return $transformed_calendars;

    }

    public function trainings($user_id) {

        $calendars = Calendar::where('user_id',$user_id)
                            ->where('training_id','!=',null)
                            ->orderby('id','DESC')
                            ->with('training')
                            ->get()->groupBy('date','user_id');

        $transformed_calendars = [];

        foreach ($calendars as $calendar) {

            array_push($transformed_calendars,$calendar);

        }

        return $transformed_calendars;

        return $calendars;

    }
}
