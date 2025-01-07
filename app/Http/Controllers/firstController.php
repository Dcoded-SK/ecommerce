<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class firstController extends Controller
{

    // to show home page

    public function home()
    {
        return view('index');
    }
}