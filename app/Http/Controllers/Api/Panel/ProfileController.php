<?php

namespace App\Http\Controllers\Api\Panel;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{

    public function index()
    {
        $user = auth('api')->user();
        $user = User::where('id',$user->id)->with('profile')->first();
        return $user;
    }

}
