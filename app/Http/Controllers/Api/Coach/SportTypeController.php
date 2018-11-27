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
        return $coach->sports;



    }

    public function show($sport_id)
    {


        $coach = auth('api')->user();
        $field = $coach->getField;
        $programs = Programs::where('sport_id',$sport_id)
                            ->where($field,$coach->id)
                            ->where('status','!=','reject')
                            ->orderby('id','DESC')
                            ->with('user.profile')
                            ->get();

        return $programs;


    }



}
