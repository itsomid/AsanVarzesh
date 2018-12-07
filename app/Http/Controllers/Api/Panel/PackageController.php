<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Food;
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

        $messsages = array(
            'title.required'=>'پرکردن فیلد عنوان الزامی ست',
            'description.required'=>'پرکردن فیلد نام الزامی ست',
            'how_to_cooking.required'=>'پرکردن فیلد نحوه پخت الزامی ست',
            'image.required'=>'تصویر را انتخاب کنید'
        );
        $validator = Validator::make($request->all(), [
            'title' => 'required|numeric|unique:users',
            'description' => 'required',
            'how_to_cooking' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif|required'
        ],$messsages);

        if ($validator->fails()) {

            return response()->json(['message' => $validator->errors()->first()],406);

        }

        $ext = $request->image->getClientOriginalExtension();
        $path = $request->image->storeAs('/', md5(time()).'.'.$ext, 'photos');
        $url = 'storage/photos/'.$path;

        $this->nutValues(\GuzzleHttp\json_decode($data['foods'],1));


        $package = new Package();
        $package->title = $data['title'];
        $package->description = $data['description'];
        $package->how_to_cooking = $data['how_to_cooking'];
        $package->image = $url;
        $package->nutritional_value = $this->nutValues(\GuzzleHttp\json_decode($data['foods'],1));;
        $package->save();

        foreach (\GuzzleHttp\json_decode($data['foods'],1)  as $food) {
            $package->foods()->attach($food['food_id'],['title' => $data['title'],'unit' => $food['unit'],'size' => $food['size']]);
        }

        return response()->json(['message' => 'بسته غذایی جدید اضافه شد','package' => $package],200);

    }

    public function nutValues($foods) {
        $nutritional_value = [
            [
                'title' => 'چربی',
                'size' => '',
                'unit' => 'گرم',
            ],
            [
                'title' => 'کلسیم',
                'size' => '',
                'unit' => 'گرم',
            ],
            [
                'title' => 'پروتئین',
                'size' => '',
                'unit' => 'گرم',
            ],
        ];

        $energy = 0;
        $cal = 0;
        $protein = 0;
        foreach ($foods as $food) {

            $food = Food::find($food['food_id']);
            $food;
            $energy += $food['nutritional_value'][0]['size'];
            $cal += $food['nutritional_value'][1]['size'];
            $protein += $food['nutritional_value'][2]['size'];

        }

        $nutritional_value[0]['size'] = $energy;
        $nutritional_value[1]['size'] = $cal;
        $nutritional_value[2]['size'] = $protein;
        return $nutritional_value;


    }


}
