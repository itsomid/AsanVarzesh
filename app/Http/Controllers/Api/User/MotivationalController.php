<?php

namespace App\Http\Controllers\Api\User;

use App\Model\Motivational;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MotivationalController extends Controller
{
    public function random() {

        $motivate = Motivational::inRandomOrder()->first();
        return $motivate;

    }
}
