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

        $messsages = array(
            'title.required'=>'پرکردن فیلد عنوان الزامی ست',
            'description.required'=>'پرکردن فیلد توضیحات الزامی ست',
            'federation_id.required'=>'فدراسیون را انتخاب کنید',
        );
        $validator = Validator::make($request->all(), [
            'title' => 'required|numeric|unique:users',
            'description' => 'required',
            'federation_id' => 'required'
        ],$messsages);

        if ($validator->fails()) {

            return response()->json(['message' => $validator->errors()->first()],406);

        }

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
