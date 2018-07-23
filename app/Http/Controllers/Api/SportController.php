<?php

namespace App\Http\Controllers\Api;

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
}
