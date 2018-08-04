<?php

namespace App\Http\Controllers\Api\Coach;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function show($user_id)
    {

        $user = User::find($user_id);

        return response()->json($user->profile,200);

    }
}
