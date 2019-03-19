<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Accessory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AccessoryController extends Controller
{

    public function index() {
        $accessories = Accessory::orderby('id','DESC')->get();
        return $accessories;
    }

    public function show($id) {
        $accessory = Accessory::find($id);
        return $accessory;
    }

    public function store(Request $request) {
        $data = $request->all();

        $messsages = array(
            'name' => 'نام را وارد کنید',
            'image' => 'عکس را انتخاب کنید'
        );

        $rules = [
            'name' => 'required',
            'image' => 'required|image'
        ];

        $validator = Validator::make($request->all(), $rules, $messsages);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()],406);
        }



        $accessory = new Accessory();
        $accessory->name = $data['name'];
        $accessory->img = $img;
        $accessory->save();

        response()->json(['message' => 'وسیله مورد نظر اضافه شد'],200);

    }

    public function update(Request $request,$id) {

        $data = $request->all();

        if(array_key_exists('new_image',$data) AND !is_null($data['new_image']) && $data['new_image'] != '') {
            $ext = $request->new_image->getClientOriginalExtension();
            $path = $request->new_image->storeAs('/', md5(time()).'.'.$ext, 'accessories');
            $img = 'storage/accessories/'.$path;
        } else {
            $img = $data['image'];
        }

        $accessory = Accessory::find($id);
        $accessory->name = $data['name'];
        $accessory->img = $img;
        $accessory->save();

    }

}
