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
        $isCoach = $this->isCoach($user->roles);
        if($isCoach) {
            $allSports = [];
            foreach ($user->sports as $sport) {
                $programs_count = Programs::where('sport_id',$sport->id)
                    ->where('coach_id',$user->id)
                    ->whereIn('status',['active','accept'])
                    ->count();
                $sportArray = $sport->toArray();
                $sportArray['number_of_users'] = $programs_count;
                array_push($allSports,$sportArray);
            }
            return $allSports;
        }

        $role = $user->roles[0]->name;
        if($role == 'nutrition-doctor') {

            $programs = Programs::with('sport')->where('nutrition_doctor_id',$user->id)
                                    ->whereIn('status',['active'])
                                    ->get();
            $sports = [];
            foreach ($programs as $program) {
                $sport = $program->sport;
                array_push($sports,$sport);
            }
            $sports = array_unique($sports);
            $allSports = [];
            foreach ($sports as $sport) {
                $programs_count = $programs->where('sport_id',$sport->id)->count();
                $sportArray = $sport->toArray();
                $sportArray['number_of_users'] = $programs_count;
                array_push($allSports,$sportArray);
            }
            return $allSports;

        } elseif($role == 'corrective-doctor') {

            $programs = Programs::with('sport')->where('corrective_doctor_id',$user->id)
                ->whereIn('status',['active'])
                ->get();

            $sports = [];
            foreach ($programs as $program) {
                $sport = $program->sport;
                array_push($sports,$sport);
            }

            $sports = array_unique($sports);
            $allSports = [];
            foreach ($sports as $sport) {
                $programs_count = $programs->where('sport_id',$sport->id)->count();
                $sportArray = $sport->toArray();
                $sportArray['number_of_users'] = $programs_count;
                array_push($allSports,$sportArray);
            }
            return $allSports;
        }


    }

    public function show($sport_id)
    {

        $user = auth('api')->user();
        $field = $user->getFieldProgram();

        $programs = Programs::where('sport_id',$sport_id)
                            ->where($field,$user->id)
                            ->whereIn('status',['active'])
                            ->orderby('id','DESC')
                            ->with('user.profile.city')
                            ->get();
        return $programs;





    }

    public function isCoach($roles) {
        $isCoach = false;
        foreach ($roles as $role) {
            if($role->name == 'coach') {
                $isCoach = true;
            }
        }
        return $isCoach;
    }


}
