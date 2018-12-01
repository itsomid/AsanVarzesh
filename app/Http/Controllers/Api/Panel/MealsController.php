<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Meal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MealsController extends Controller
{
    public function index() {

        $meals = Meal::all();

        return $meals;

    }
}
