<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Food;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FoodController extends Controller
{
    public function index() {

        $foods = Food::orderby('id','DESC')->get();
        return response()->json($foods,200);

    }

    public function store(Request $request)
    {
        $data = $request->all();

        $ext = $request->image->getClientOriginalExtension();
        $path = $request->image->storeAs('/', md5(time()).'.'.$ext, 'photos');
        $url = 'storage/photos/'.$path;

        $food = new Food();
        $food->title = $data['title'];
        $food->description = $data['description'];
        $food->details = $data['details'];
//        $food->energy = $data['energy'];
        $food->food_category_id = $data['food_category_id'];
        $food->nutritional_value = $data['nutritional_value'];
        $food->image = $url;
        $food->save();

        return response()->json(['message' => 'غذای جدید اضافه شد'],200);

    }
}
