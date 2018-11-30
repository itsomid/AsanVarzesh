<?php

namespace App\Http\Controllers\Api\Panel;

use App\Model\Sport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SportController extends Controller
{
    public function index() {

        return Sport::all();

    }
}
