<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SportTypeController extends Controller
{
    //
    public function index() {

        $sport_type =  [
            [
                'title' => 'عمومی',
                'value' => 'public'
            ],
            [
                'title' => 'تخصصی',
                'value' => 'specialized'
            ]
        ];


        return response()->json($sport_type,200);

    }
}
