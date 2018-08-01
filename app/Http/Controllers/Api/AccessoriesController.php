<?php

namespace App\Http\Controllers\Api;

use App\Model\Accessory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccessoriesController extends Controller
{

    public function index()
    {
        $accessories = Accessory::all();
        return $accessories;
    }

    public function store(Request $request) {

        $data = $request->all();

        $ext = $request->img->getClientOriginalExtension();
        $path = $request->img->storeAs('/', md5(time()).'.'.$ext, 'accessories');
        $url = 'storage/accessories/'.$path;

        $accessory = new Accessory();
        $accessory->name = $data['name'];
        $accessory->img = $url;
        $accessory->save();

        return response()->json(['status' => 200,'message' => 'successfull'],200);

    }



}
