<?php

namespace App\Http\Controllers\Api\Coach;

use App\Model\Food;
use App\Model\Meal;
use App\Model\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PackageController extends Controller
{
    public function index()
    {

        $packages = Package::with('foods')->get();
        return response()->json($packages,200);
    }

    public function show($id)
    {
        $package = Package::with('foods')->where('id',$id)->first();
        return response()->json($package,200);
    }

    public function foods()
    {
        $foods = Food::all();
        return response()->json($foods,200);
    }

    public function meals() {
        $meals = Meal::all();
        return $meals;
    }

    public function store(Request $request) {
        $user = auth('api')->user();
        $data = $request->all();

        $package = new Package();
        $package->title = $user->id;
        $package->meal_id = $user->id;
        $package->unit = $user->id;
        $package->size = $user->id;
        $package->description = $user->id;
        $package->creator_id = $user->id;
        $package->save();

        foreach ($data['foods'] as $food) {
            $package->foods()->attach($package->id,['food_id' => $food['id'],'unit' => $food['unit'],'size' => $food['size']]);
        }
        $package = Package::with('foods')->where('id',$package->id)->first();
        return response()->json(['package' => $package],200);

    }
}
