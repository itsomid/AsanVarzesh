<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Motivational;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MotivisionalController extends Controller
{

    public function index() {

        $motivisionals = Motivational::orderby('id','DESC')->get();
        return $motivisionals;
    }

    public function store(Request $request) {

        $motivisional = new Motivational();
        $motivisional->phrase = $request->phrase;
        $motivisional->save();

        return response()->json(['message' => 'جمله انگیزشی جدید اضافه شد'],200);

    }

    public function delete($id) {
        $motivisional = Motivational::find($id);
        $motivisional->delete();
    }

}
