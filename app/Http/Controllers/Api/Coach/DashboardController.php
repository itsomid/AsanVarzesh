<?php

namespace App\Http\Controllers\Api\Coach;

use App\Model\Programs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index($status = null) {

        $coach = auth('api')->user();

        if($status != null) {

            $programs = Programs::with('user.profile')->where('coach_id',$coach->id)
                ->where('status',$status)
                ->orderby('id','DESC')
                ->get();

        } else {

            $programs = Programs::with('user.profile')->where('coach_id',$coach->id)
                ->orderby('id','DESC')
                ->get();
            $status = 'all';
        }



        return response()->json([
            'status' => $status,
            'programs' => $programs
        ],200);


    }
}
