<?php

namespace App\Http\Controllers\Api\User;

use App\Model\Federation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FederationController extends Controller
{
    public function index() {

        $federations = Federation::all();
        return response()->json($federations,200);


    }

    public function show($federation_type) {

        $federations = Federation::where('type',$federation_type)->get();
        return response()->json($federations,200);
    }

}
