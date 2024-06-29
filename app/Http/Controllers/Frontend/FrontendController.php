<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;



class FrontendController extends Controller
{

    public function index() : View{

        //Get all sliders
        $sliders = Slider::where('status',1)->get();


       // return view('frontend.layouts.master');
        return view('frontend.home.index', ['sliders'=>$sliders]);

    }

}
