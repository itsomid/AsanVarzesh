<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Food;
use App\Model\FoodCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FoodController extends Controller
{
    public function index() {
        $foods = Food::orderby('id','DESC')->get();
        return response()->json($foods,200);
    }

    public function show($id) {
        $food = Food::find($id);
        return response()->json($food,200);
    }

    public function update(Request $request,$id) {
        $data = $request->all();

        $messsages = array(
            'title.required'=>'پرکردن فیلد عنوان الزامی ست',
            'description.required'=>'پرکردن فیلد نام الزامی ست',
            'food_category_id.required'=>'پرکردن فیلد دسته بندی الزامی ست',
            'new_image.image'=>'فرمت تصویر درست نیست'
        );
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'food_category_id' => 'required',
        ];

        if(array_key_exists('new_image',$data)) {
            $rules['new_image'] = 'image';
        }

        $validator = Validator::make($request->all(), $rules,$messsages);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()],406);
        }


        $image = '';
        if(array_key_exists('new_image',$data)) {
            $ext = $request->new_image->getClientOriginalExtension();
            $path = $request->new_image->storeAs('/', md5(time()).'.'.$ext, 'photos');
            $image = 'storage/photos/'.$path;
        } else {
            $image = $data['image'];
        }


        $food = Food::find($id);
        $food->title = $data['title'];
        $food->description = $data['description'];
        $food->food_category_id = $data['food_category_id'];
        $food->nutritional_value = \GuzzleHttp\json_decode($data['nutritional_value'],1);
        $food->enable = $data['enable'];
        $food->image = $image;
        $food->save();


        return response()->json(['message' => 'غذا اصلاح شد'],200);

    }

    public function category() {
        $cats = FoodCategory::all();
        return $cats;
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $messsages = array(
            'title.required'=>'پرکردن فیلد عنوان الزامی ست',
            'description.required'=>'پرکردن فیلد نام الزامی ست',
            'food_category_id.required'=>'پرکردن فیلد دسته بندی الزامی ست',
            'image.required'=>'تصویر را انتخاب کنید'
        );
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'food_category_id' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif|required'
        ],$messsages);


        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()],406);
        }



        $ext = $request->image->getClientOriginalExtension();
        $path = $request->image->storeAs('/', md5(time()).'.'.$ext, 'photos');
        $url = 'storage/photos/'.$path;

        $food = new Food();
        $food->title = $data['title'];
        $food->description = $data['description'];
        $food->details = '';
        $food->food_category_id = $data['food_category_id'];
        $food->nutritional_value = \GuzzleHttp\json_decode($data['nutritional_value'],1);
        $food->details = '';
        $food->image = $url;
        $food->enable = true;
        $food->save();

        return response()->json(['message' => 'غذای جدید اضافه شد'],200);

    }
}
