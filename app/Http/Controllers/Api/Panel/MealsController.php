<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Meal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MealsController extends Controller
{
    public function index() {
        $meals = Meal::orderby('id','DESC')->get();
        return $meals;
    }

    public function store(Request $request) {
        $data = $request;
        $meal = new Meal();
        $meal->title = $data['title'];
        $meal->save();

        return response()->json(['message' => 'وعده غذایی اضافه شد'],200);
    }

    public function delete($meal_id) {
        $meal = Meal::find($meal_id);
        $meal->delete();
    }
}