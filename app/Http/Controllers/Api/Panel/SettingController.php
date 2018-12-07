<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{

    public function index() {

        $settings = Setting::all();
        return $settings;

    }

    public function store(Request $request) {

        $data = $request->all();
        foreach ($data as $item) {
            $item = \GuzzleHttp\json_decode($item,1);



            $setting = Setting::where('title',$item['title'])->first();
            $setting->value = $item['value'];
            $setting->save();

        }

    }


}
