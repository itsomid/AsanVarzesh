<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Training;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class TrainingsController extends Controller
{
    public function index(Request $request) {
        $data = $request->all();
        if(isset($data['search'])) {
            $trainings = Training::with('sport')->where('title','LIKE','%'.$data['search'].'%')->where('enable',true)->orderBy('id','DESC')->get();
        } else {
            $trainings = Training::with('sport')->where('enable',true)->orderBy('id','DESC')->get();
        }

        return response()->json($trainings,200);
    }

    public function show($id) {

        $training = Training::with('sport','accessories')->where('id',$id)->first();
        return response()->json($training,200);

    }

    public function update(Request $request,$id) {
        $data = $request->all();
        $accessories = json_decode($data['accessories'],1);

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
            $path = $request->new_image->storeAs('/', md5(time()) . '.' . $ext, 'photos');
            $image = 'storage/photos/' . $path;
        } else {
            $image = $data['image'];
        }

        if(array_key_exists('new_attachment',$data)) {
            $ext = $request->new_attachment->getClientOriginalExtension();
            $path = $request->new_attachment->storeAs('/', md5(time()) . '.' . $ext, 'videos');
            $video = 'storage/videos/' . $path;
        } else {
            $video = $data['attachment'];
        }

        if(array_key_exists('new_audio_short',$data)) {
            $ext = $request->new_audio_short->getClientOriginalExtension();
            $path = $request->new_audio_short->storeAs('/', md5(time()) . '.' . $ext, 'audios');
            $audio_short = 'storage/audios/' . $path;
        } else {
            $audio_short = $data['audio_short'];
        }

        if(array_key_exists('new_audio_full',$data)) {
            $ext = $request->new_audio_full->getClientOriginalExtension();
            $path = $request->new_audio_full->storeAs('/', md5(time()) . '.' . $ext, 'audios');
            $audio_full = 'storage/audios/' . $path;
        } else {
            $audio_full = $data['audio_full'];
        }



        $training = Training::find($id);
        $training->title = $data['title'];
        $training->sport_id = $data['sport_id'];
        $training->difficulty = $data['difficulty'];
        $training->details = $data['details'];
        $training->attribute = json_decode($data['attribute']);
        $training->attachment = $video;
        $training->audio_full = $audio_full;
        $training->audio_short = $audio_short;
        $training->image = $image;
        $training->enable = $data['enable'];
        $training->save();

        $training->accessories()->sync($accessories);

        //return response()->json($training->accessories,400);

        return response()->json(['message' => 'تمرین ویرایش شد'],200);


    }

    public function store(Request $request) {

        $data = $request->all();
        $accessories = json_decode($data['accessories'],1);
        $attribute = \GuzzleHttp\json_decode($data['attribute'],1);

        $messsages = array(
            'title.required'=>'پرکردن فیلد عنوان الزامی ست',
            'sport_id.required'=>'انتخاب ورزش الزامی ست',
            //'image.required'=>'تصویر را انتخاب کنید',
            //'attachment.required'=>'ویدیو را انتخاب کنید',
            'difficulty.required'=>'میزان دشواری را انتخاب کنید',
        );

        $rules = [
            'title' => 'required',
            'sport_id' => 'required',
            'image' => 'required',
            //'attachment' => 'required',
            'difficulty' =>'required',
        ];

        $validator = Validator::make($request->all(), $rules,$messsages);
        if($data['type'] == 0) {
            $validator->after(function ($validator) use ($attribute) {
                if(
                    $attribute['distance'] == 0 ||
                    $attribute['speed'] == 0 ||
                    $attribute['time'] == 0 ||
                    $attribute['unit_speed'] == ''
                ) {

                    $validator->errors()->add('attributes', 'فیلدهای ویژگی را پر کنید');
                }
            });
        }

        if($data['type'] == 1) {
            $validator->after(function ($validator) use ($attribute) {
                if(
                    $attribute['each_set'] == 0 ||
                    $attribute['set'] == 0 ||
                    $attribute['time_each_set'] == 0
                ) {
                    $validator->errors()->add('attributes', 'فیلدهای ویژگی را پر کنید');
                }
            });
        }

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()],406);
        }



        if(array_key_exists('image',$data)) {
            $ext = $request->image->getClientOriginalExtension();
            $path = $request->image->storeAs('/', md5(time()) . '.' . $ext, 'photos');
            $image = 'storage/photos/' . $path;
        } else {
            $image = '';
        }

        if(array_key_exists('attachment',$data)) {
            $ext = $request->attachment->getClientOriginalExtension();
            $path = $request->attachment->storeAs('/', md5(time()) . '.' . $ext, 'videos');
            $video = 'storage/videos/' . $path;
        } else {
            $video = '';
        }

        if(array_key_exists('audio_short',$data)) {
            $ext = $request->audio_short->getClientOriginalExtension();
            $path = $request->audio_short->storeAs('/', md5(time()) . '.' . $ext, 'audios');
            $audio_short = 'storage/audios/' . $path;
        } else {
            $audio_short = '';
        }

        if(array_key_exists('audio_full',$data)) {
            $ext = $request->audio_full->getClientOriginalExtension();
            $path = $request->audio_full->storeAs('/', md5(time()) . '.' . $ext, 'audios');
            $audio_full = 'storage/audios/' . $path;
        } else {
            $audio_full = '';
        }

        if($data['type'] == 0) {
            $attribute['set'] = null;
            $attribute['each_set'] = null;
            $attribute['time_each_set'] = null;
        } else {
            $attribute['distance'] = null;
            $attribute['speed'] = null;
            $attribute['time'] = null;
            $attribute['unit_speed'] = null;
        }

        $training = new Training();
        $training->title = $data['title'];
        $training->sport_id = $data['sport_id'];
        $training->attachment = $video;
        $training->audio_full = $audio_full;
        $training->audio_short = $audio_short;
        $training->image = $image;
        $training->difficulty = $data['difficulty'];
        if(isset($data['details'])) {
            $training->details = $data['details'];
        }
        $training->attribute = \GuzzleHttp\json_decode($data['attribute'],1);
        $training->enable = true;
        $training->save();


        $training->accessories()->attach($accessories);

        return response()->json(['message' => 'تمرین جدید اضافه شد'],200);

    }
}
