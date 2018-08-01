<?php

namespace App\Http\Controllers\Api;

use App\Model\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{

    public function show($plan_id) {

        $plan = Plan::where('id',$plan_id)->first();
        return response()->json($plan,200);

    }

    public function bySportId($sport_id) {

        $plans = Plan::where('sport_id',$sport_id)->get();
        return response()->json($plans,200);

    }

}
