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
                'image' => 'https://static3.eghtesadnews.com/thumbnail/XHYCsrvLUztC/kzxwgq-JKBXtdnsW2DbwP_oAq30e7qnHfcABTZgEjDPeX92dFRcloYZucmNEhMAiywpgzrCJSonkiG3pI_QvVJMtK7Jf75PBp16mubDQHsIoEbt60vt-xA,,/%D9%88%D8%B1%D8%B2%D8%B4.jpg'
            ],
            [
                'title' => 'تخصصی',
                'value' => 'specialized',
                'image' => 'https://hmsnews.org/wp-content/uploads/2017/03/sports.jpg'
            ]
        ];


        return response()->json($sport_type,200);

    }
}
