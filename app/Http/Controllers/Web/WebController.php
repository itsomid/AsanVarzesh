<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebController extends Controller
{
    public function index() {
        return view('index');
    }

    public function coach() {
        return view('coach');
    }
    public function experts() {
        return view('experts');
    }
    public function specialists() {
        return view('specialists');
    }

    public function ruleCoach()
    {
        return view('condition_coach');
    }
    public function ruleAv()
    {
        return view('condition_av');
    }
    public function ruleUser()
    {
        return view('condition_user');
    }
}
