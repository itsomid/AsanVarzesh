<?php

namespace App\Http\Controllers\Api\Coach;

use App\Model\Training;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TrainingController extends Controller
{
    public function trainings($sport_id) {

        $trainings = Training::all();
        return $trainings;

    }
}
