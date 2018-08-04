<?php

namespace App\Http\Controllers\Api\User;

use App\Model\Sport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SportController extends Controller
{
    //
    public function show($federation_id) {


        // Show Sports by Federations
        $sports = Sport::where('federation_id',$federation_id)->get();

        return response()->json($sports,200);

    }

    public function publicSport() {

        $sports = Sport::where('federation_id',1)->get();

        return response()->json($sports,200);

    }
}
