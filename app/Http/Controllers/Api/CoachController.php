<?php

namespace App\Http\Controllers\Api;

use App\Model\Profiles;
use App\Model\Sport;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CoachController extends Controller
{
    //

    public function bySport($sport_id,$keywords = null,$capacity_full = 'no') {

        $sports = Sport::with('coachs.profile')->where('id',$sport_id)->first();
        return $sports;
    }

    public function filter($sport_id,Request $request) {

        $keywords = $request->keywords;
        $capacity_full = $request->capacity_full;
        $by_price = $request->price;

        $sports = Sport::with(['coachs.profile' =>
            function($query) use ($keywords) {
                $query->where('keywords','like','%'.$keywords.'%');
            }])->where('id',$sport_id)->first();

        $coachs = [];

        foreach ($sports->coachs as $coach) {
            if($coach['profile']) {
                array_push($coachs,$coach->profile);
            }
        }

        return response()->json($coachs,200);

    }

    public function show($coach_id) {

        $profile = Profiles::where('id',$coach_id)->first();
        return response()->json($profile,200);

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
