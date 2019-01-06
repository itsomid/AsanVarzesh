<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Training;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class TrainingsController extends Controller
{
    public function index() {
        $trainings = Training::with('sport')->orderBy('id','DESC')->get();
        return response()->json($trainings,200);
    }

    public function show($id) {

        $training = Training::with('sport')->where('id',$id)->first();
        return response()->json($training,200);

    }

    public function update(Request $request,$id) {
        $data = $request->all();

        $messsages = array(
            'title.required'=>'پرکردن فیلد عنوان الزامی ست',
            'sport_id.required'=>'انتخاب ورزش الزامی ست',
            'image.required'=>'تصویر را انتخاب کنید',
            'image.image'=>'تصویر را انتخاب کنید',
//            'attachment.required'=>'ویدیو را انتخاب کنید',
//            'image.required'=>'ویدیو را انتخاب کنید',
            'difficulty.required'=>'میزان سختی را انتخاب کنید',
        );

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'sport_id' => 'required',
//            'image' => 'required|image',
//            'attachment' => 'required|image',
            'difficulty' =>'required',
        ],$messsages);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()],406);
        }

        if(array_key_exists('new_image',$data)) {
            $ext = $request->new_image->getClientOriginalExtension();
            $path = $request->new_image->storeAs('/', md5(time()).'.'.$ext, 'photos');
            $training_image = 'storage/photos/'.$path;
        } else {
            $training_image = $data['image'];
        }

        if(array_key_exists('new_attachment',$data)) {
            $ext = $request->new_attachment->getClientOriginalExtension();
            $path = $request->new_attachment->storeAs('/', md5(time()).'.'.$ext, 'videos');
            $video_image = 'storage/videos/'.$path;
        } else {
            $video_image = $data['attachment'];
        }

        $training = Training::find($id);
        $training->title = $data['title'];
        $training->sport_id = $data['sport_id'];
        $training->attachment = $video_image;
        $training->difficulty = $data['difficulty'];
        $training->details = $data['details'];
        $training->attribute = json_decode($data['attribute']);
        $training->image = $training_image;
        $training->save();


        return response()->json(['message' => 'تمرین ویرایش شد'],200);


    }

    public function store(Request $request) {

        $data = $request->all();

        $messsages = array(
            'title.required'=>'پرکردن فیلد عنوان الزامی ست',
            'sport_id.required'=>'انتخاب ورزش الزامی ست',
            'image.required'=>'تصویر را انتخاب کنید',
            'attachment.required'=>'ویدیو را انتخاب کنید',
            'difficulty.required'=>'میزان سختی را انتخاب کنید',
        );

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:users',
            'sport_id' => 'required',
            'image' => 'required',
            'attachment' => 'required',
            'difficulty' =>'required',
        ],$messsages);

        if ($validator->fails()) {

            return response()->json(['message' => $validator->errors()->first()],406);

        }

        $ext = $request->image->getClientOriginalExtension();
        $path = $request->image->storeAs('/', md5(time()).'.'.$ext, 'photos');
        $training_image = 'storage/photos/'.$path;

        $ext = $request->attachment->getClientOriginalExtension();
        $path = $request->attachment->storeAs('/', md5(time()).'.'.$ext, 'videos');
        $video_image = 'storage/videos/'.$path;

        $training = new Training();
        $training->title = $data['title'];
        $training->sport_id = $data['sport_id'];
        $training->attachment = $video_image;
        $training->difficulty = $data['difficulty'];
        $training->details = $data['details'];
        $training->attribute = $data['attribute'];
        $training->image = $training_image;
        $training->save();

        return response()->json(['message' => 'تمرین جدید اضافه شد'],200);

    }
}
