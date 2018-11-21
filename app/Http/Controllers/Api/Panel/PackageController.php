<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::with('foods')->orderby('id','DESC')->get();
        return response()->json($packages,200);
    }

    public function store(Request $request)
    {

        $data = $request->all();

        $ext = $request->image->getClientOriginalExtension();
        $path = $request->image->storeAs('/', md5(time()).'.'.$ext, 'photos');
        $url = 'storage/photos/'.$path;

        $package = new Package();
        $package->title = $data['title'];
        $package->description = $data['description'];
        $package->how_to_cooking = $data['how_to_cooking'];
        $package->image = $url;
        $package->nutritional_value = $data['nutritional_value'];
        $package->save();

        foreach ($data['foods'] as $food) {
            $package->foods()->attach($food['food_id'],['title' => $data['title'],'unit' => $food['unit'],'size' => $food['size']]);
        }

        return response()->json(['message' => 'بسته غذایی جدید اضافه شد','package' => $package],200);

    }

}
