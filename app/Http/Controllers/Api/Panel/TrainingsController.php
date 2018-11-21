<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Training;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TrainingsController extends Controller
{
    public function index() {
        $trainings = Training::with('sport')->orderBy('id','DESC')->get();
        return response()->json($trainings,200);
    }

    public function store(Request $request) {

        $data = $request->all();

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
