<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Federation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FederationController extends Controller
{
    public function index()
    {
        $federations = Federation::where('type','specialized')->orderby('id','DESC')->get();
        return $federations;
    }

    public function show($id)
    {
        $federation = Federation::find($id);
        return $federation;
    }

    public function update($id, Request $request)
    {
        $data = $request->all();
        // Upload New Image
        if(array_key_exists('new_image',$data) AND !is_null($data['new_image']) && $data['new_image'] != '') {
            $ext = $data['new_image']->getClientOriginalExtension();
            $path = $data['new_image']->storeAs('/', md5(time().microtime()).'.'.$ext, 'federations');
            $image = 'storage/federations/'.$path;
        } else {
            $image = $data['image'];
        }
        $federation = Federation::find($id);
        $federation->name = $data['name'];
        $federation->image = $image;
        $federation->save();

    }

    public function store(Request $request)
    {
        $data = $request->all();
        $messsages = array(
            'name.required' => 'نام را وارد کنید',
            'image.image' => 'فرمت تصویر درست نیست',
        );

        $rules = [
            'name' => 'required',
            'image' => 'image',
        ];

        $validator = Validator::make($request->all(), $rules, $messsages);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()],406);
        }

        if(array_key_exists('image',$data) AND !is_null($data['image']) && $data['image'] != '') {
            $ext = $data['image']->getClientOriginalExtension();
            $path = $data['image']->storeAs('/', md5(time().microtime()).'.'.$ext, 'federations');
            $image = 'storage/federations/'.$path;
        } else {
            $image = null;
        }

        $federation = new Federation();
        $federation->name = $data['name'];
        $federation->type = 'specialized';
        $federation->image = $image;
        $federation->save();

        return response()->json(['federation' => $federation],200);
    }
}
