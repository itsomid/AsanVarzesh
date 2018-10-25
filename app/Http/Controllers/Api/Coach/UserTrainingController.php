<?php

namespace App\Http\Controllers\Api\Coach;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserTrainingController extends Controller
{

    public function userTraining($user_id)
    {

        $user = User::with(['profile','today_training.training','today_nutrition.package.foods.category','today_nutrition.meal'])->find($user_id);
        return $user;

    }

}
