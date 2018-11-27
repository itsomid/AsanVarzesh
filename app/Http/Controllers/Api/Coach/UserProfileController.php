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
            'conversations',
            'conversations_private',
            'sport_by_coach' =>function($q){$q->with('sport');},
            ])->where('id',$user_id)->first()->toArray();



        $program = Programs::where('user_id',$user_id)
                            ->where($field,$coach->id)
                            ->orderBy('id','DESC')
                            ->first();
        return $program->calendar;
        if(count($program->calendar->groupBy('date')) > 0) {
            $calendar = $program->calendar->groupBy('date')->toArray();
            reset($calendar);
            $first_day = key($calendar);

            end($calendar);
            $last_day = key($calendar);

            $user['first_day'] = $first_day;
            $user['last_day'] = $last_day;
            $user['nutrition_calendar'] = $this->diet($user['id']);
            return $user;
        } else {
            $user['nutrition_calendar'] = [];
        }

        return $user;




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
