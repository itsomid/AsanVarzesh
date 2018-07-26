<?php

namespace App\Http\Controllers\Api;

use App\Model\Accessory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccessoriesController extends Controller
{

    public function index()
    {
        $accessories = Accessory::all();
        return $accessories;
    }



}
