<?php

namespace App\Http\Controllers\Api;

use App\Model\Profiles;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CoachController extends Controller
{
    //

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
