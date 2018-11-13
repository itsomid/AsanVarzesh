<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SportTypeController extends Controller
{
    //
    public function index() {

        $sport_type =  [
            [
                'title' => 'عمومی',
                'value' => 'public',
                'image' => url('images/omoomi.jpg')
            ],
            [
                'title' => 'تخصصی',
                'value' => 'specialized',
                'image' => url('images/takhasosi.jpg')
            ]
        ];


        return response()->json($sport_type,200);

    }
}
