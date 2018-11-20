<?php

namespace App\Http\Controllers\Api\Panel;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AthletesController extends Controller
{

    public function index()
    {

        $user_role = \App\Model\Role::find(2);
        $users = $user_role->users()->with(['programs.sport','profile'])->get();

        return response()->json($users,200);

    }

    public function show($user_id)
    {

        $user = User::with(['activities','programs.sport','profile'])->where('id',$user_id)->first();

        return response()->json($user,200);

    }
}
