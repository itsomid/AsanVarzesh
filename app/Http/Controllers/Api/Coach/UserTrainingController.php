<?php

namespace App\Http\Controllers\Api\Coach;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserTrainingController extends Controller
{

    public function userTraining($user_id)
    {

        $user = User::with(['profile','today_training.training.sport','today_nutrition.package.foods.category','today_nutrition.meal'])->find($user_id);
        $user_arr = $user->toArray();
        $user_arr['private_conversations'] = $user->conversations()->where('type','private')->with(['user.profile','user.roles'])->get();
        $user_arr['group_conversations'] = $user->conversations()->where('type','group')->with(['user.profile','user.roles'])->get();

        return $user_arr;

    }

}
