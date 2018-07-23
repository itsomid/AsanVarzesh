<?php

namespace App\Http\Controllers\Api;

use App\Model\Profiles;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CoachController extends Controller
{
    //
    public function search($keyword) {

        $profiles = Profiles::where('keywords','like','%'.$keyword.'%')->get();
        return $profiles;

    }
}
