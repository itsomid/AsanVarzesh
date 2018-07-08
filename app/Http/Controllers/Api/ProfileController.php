<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    //
    public function getProfile(Request $request)
    {
        $user = response()->json(auth()->user());
        return $user;
    }
}
