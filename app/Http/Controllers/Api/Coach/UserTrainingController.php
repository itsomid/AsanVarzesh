<?php

namespace App\Http\Controllers\Api\Coach;

use App\Model\Conversation;
use App\Model\Programs;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserTrainingController extends Controller
{

    public function userTraining($user_id)
    {

        $coach = auth('api')->user();
        $field = $coach->getField();
        $user = User::with(['profile','today_training.training.sport','today_nutrition.package.foods.category','today_nutrition.meal'])->find($user_id);
        $user_arr = $user->toArray();

        $programs = Programs::where('user_id',$user->id)->where($field,$coach->id)->pluck('id');

        $user_arr['private_conversations'] = $coach->conversations()->whereIn('program_id',$programs)->where('type','private')->with(['user.profile','user.roles'])->get();
        $user_arr['group_conversations'] = $coach->conversations()->whereIn('program_id',$programs)->where('type','group')->with(['user.profile','user.roles'])->get();

        return $user_arr;

    }

}
