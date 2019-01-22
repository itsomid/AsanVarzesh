<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Federation;
use App\Model\Sport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

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

    public function show($id) {

        $sport = Sport::find($id);
        return $sport;

    }

    public function update(Request $request,$id) {

        $data = $request->all();

        if(array_key_exists('new_image',$data) AND !is_null($data['new_image']) && $data['new_image'] != '') {
            $ext = $request->new_image->getClientOriginalExtension();
            $path = $request->new_image->storeAs('/', microtime(time()).'.'.$ext, 'sports');
            $image = 'storage/sports/'.$path;
        } else {
            $image = $data['image'];
        }

        $sport = Sport::find($id);
        $sport->title = $data['title'];
        $sport->description = $data['description'];
        $sport->federation_id = $data['federation_id'];
        $sport->image = $image;
        $sport->save();
        return [$sport,$data];

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
            'title' => 'required',
            'description' => 'required',
            'federation_id' => 'required'
        ],$messsages);

        if ($validator->fails()) {

            return response()->json(['message' => $validator->errors()->first()],406);

        }

        $ext = $request->image->getClientOriginalExtension();
        $path = $request->image->storeAs('/', md5(time()).'.'.$ext, 'sports');
        $sport_url = 'storage/sports/'.$path;

        $sport = new Sport();
        $sport->title = $data['title'];
        $sport->description = $data['description'];
        $sport->federation_id = $data['federation_id'];
        $sport->image = $sport_url;
        $sport->save();


        return response()->json(['message' => 'ورزش مورد نظر اضافه شد'],200);

    }
}
