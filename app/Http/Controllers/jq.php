<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class jq extends Controller
{
    public function index(){
        return view('frontend.jquery');
    }
}
