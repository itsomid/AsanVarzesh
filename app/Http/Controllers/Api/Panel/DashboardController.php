<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function index() {

        $user_role = \App\Model\Role::find(2);
        $users = count($user_role ->users);

        $coach_role = \App\Model\Role::find(3);
        $coaches = count($coach_role->users);

        $nutrition_role = \App\Model\Role::find(4);
        $nutritions = count($nutrition_role->users);

        $corrective_role = \App\Model\Role::find(4);
        $correctives = count($corrective_role->users);

        return [
            'users' => $users,
            'coaches' => $coaches,
            'nutritions' => $nutritions,
            'correctives' => $correctives,
        ];

    }

}
