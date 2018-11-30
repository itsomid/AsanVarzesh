<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Federation;
use App\Model\Sport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SportsController extends Controller
{
    public function index()
    {
        $sports = Sport::orderby('id','DESC')->get();
        return response()->json($sports,200);
    }

    public function federations() {

        $federations = Federation::all();

        return response()->json($federations,200);

    }

    public function store(Request $request)
    {

        $data = $request->all();

        $ext = $request->image->getClientOriginalExtension();
        $path = $request->image->storeAs('/', md5(time()).'.'.$ext, 'photos');
        $sport_url = 'storage/photos/'.$path;

        $sport = new Sport();
        $sport->title = $data['title'];
        $sport->description = $data['description'];
        $sport->federation_id = $data['federation_id'];
        $sport->image = $sport_url;
        $sport->save();


        return response()->json(['message' => 'ورزش مورد نظر اضافه شد'],200);

    }
}
