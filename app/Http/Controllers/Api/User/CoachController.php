<?php

namespace App\Http\Controllers\Api\User;

use App\Model\Profiles;
use App\Model\Sport;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CoachController extends Controller
{
    //

    public function bySport($sport_id,$keywords = null,$capacity_full = 'no') {

        $sports = Sport::with('coaches.profile')->where('id',$sport_id)->first();
        return $sports;
    }

    public function filter($sport_id,Request $request) {

        $keywords = $request->keywords;
        $capacity_full = $request->capacity_full;
        $by_price = $request->price;

        return $sports = Sport::with(['coaches.profile' =>
            function($query) use ($keywords) {

                $query->where('keywords','like','%'.$keywords.'%');

            }])->where('id',$sport_id)->first();

        $coaches = [];

        foreach ($sports->coaches as $coach) {
            if($coach['profile']) {
                array_push($coaches,$coach->profile);
            }
        }

        return response()->json($coaches,200);

    }

    public function show($coach_id) {

        $user = User::with('profile','sports')->where('id',$coach_id)->first();
        return response()->json($user,200);

    }

    public function search($keyword,$sport_id) {

        $profiles = Profiles::/*whereHas(
            'user.roles', function ($query) use ($sport_id) {
                $query->where('sport_id', $sport_id);
            })
            ->*/where('keywords','like','%'.$keyword.'%')
            ->get();

        /*$profiles = Profiles::with('user.roles')
            ->where('keywords','like','%'.$keyword.'%')
            ->get();*/

        return response()->json($profiles,200);


    }
}
