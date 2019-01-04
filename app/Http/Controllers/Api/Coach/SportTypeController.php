<?php

namespace App\Http\Controllers\Api\Coach;

use App\Model\Programs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SportTypeController extends Controller
{

    public function index()
    {

        $coach = auth('api')->user();
        $allSports = [];
        foreach ($coach->sports as $sport) {

            $programs_count = Programs::where('sport_id',$sport->id)
                                        ->where('coach_id',1)
                                        ->where('status','active')
                                        ->count();
            $sportArray = $sport->toArray();
            $sportArray['number_of_users'] = $programs_count;
            array_push($allSports,$sportArray);
        }

        return $allSports;

    }

    public function show($sport_id)
    {


        $coach = auth('api')->user();
        $field = $coach->getField();
        $programs = Programs::where('sport_id',$sport_id)
                            ->where($field,$coach->id)
                            ->whereIn('status',['accept','active'])
                            ->orderby('id','DESC')
                            ->with('user.profile')
                            ->get();

        return $programs;


    }



}
