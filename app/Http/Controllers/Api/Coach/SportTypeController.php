<?php

namespace App\Http\Controllers\Api\Coach;

use App\Model\Programs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SportTypeController extends Controller
{

    public function index()
    {
        $user = auth('api')->user();
        $role = $user->roles[0]->name;

        if($role == 'coach') {

            $allSports = [];
            foreach ($user->sports as $sport) {
                $programs_count = Programs::where('sport_id',$sport->id)
                    ->where('coach_id',$user->id)
                    ->whereIn('status',['active','pending','accept'])
                    ->count();
                $sportArray = $sport->toArray();
                $sportArray['number_of_users'] = $programs_count;
                array_push($allSports,$sportArray);
            }
            return $allSports;
        } elseif($role == 'nutrition-doctor') {

            $programs = Programs::with('sport')->where('nutrition_doctor_id',$user->id)
                                    ->whereIn('status',['active','pending','accept'])
                                    ->get();
            $sports = [];
            foreach ($programs as $program) {
                $sport = $program->sport;
                array_push($sports,$sport);
            }

            $allSports = [];
            foreach ($sports as $sport) {
                $programs_count = Programs::where('sport_id',$sport->id)
                    ->where('nutrition_doctor_id',$user->id)
                    ->whereIn('status',['active','pending','accept'])
                    ->count();
                $sportArray = $sport->toArray();
                $sportArray['number_of_users'] = $programs_count;
                array_push($allSports,$sportArray);
            }
            return $allSports;

        } elseif($role == 'corrective-doctor') {

            $programs = Programs::with('sport')->where('corrective_doctor_id',$user->id)
                ->whereIn('status',['active','pending','accept'])
                ->get();
            $sports = [];
            foreach ($programs as $program) {
                $sport = $program->sport;
                array_push($sports,$sport);
            }

            $allSports = [];
            foreach ($sports as $sport) {
                $programs_count = Programs::where('sport_id',$sport->id)
                    ->where('corrective_doctor_id',$user->id)
                    ->whereIn('status',['active','pending','accept'])
                    ->count();
                $sportArray = $sport->toArray();
                $sportArray['number_of_users'] = $programs_count;
                array_push($allSports,$sportArray);
            }
            return $allSports;

        }


    }

    public function show($sport_id)
    {


        $coach = auth('api')->user();
        $field = $coach->getField();
        $programs = Programs::where('sport_id',$sport_id)
                            ->where($field,$coach->id)
                            ->whereIn('status',['accept','active'])
                            ->orderby('id','DESC')
                            ->with('user.profile.city')
                            ->get();

        return $programs;


    }



}
