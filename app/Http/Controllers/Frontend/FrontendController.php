<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SectionTitle;
use App\Models\Slider;
use App\Models\WhyChooseUs;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;


class FrontendController extends Controller
{

    public function index() : View{

        //Get all sliders
        $sliders = Slider::where('status',1)->get();
        $sectionTitles = $this->getSectionTitles();
        $whyChooseUs = WhyChooseUs::where('status',1)->get();

        $categories = Category::where(['show_at_home'=>1, 'status'=>1])->get();


        // return view('frontend.layouts.master');
        return view('frontend.home.index', [
            'sliders'=>$sliders,
            'sectionTitles' => $sectionTitles,
            'whyChooseUs' => $whyChooseUs,
            'categories' => $categories
        ]);

    }

    public function getSectionTitles() : Collection
    {
        $keys = [
            'why_choose_us_top_title',
            'why_choose_us_main_title',
            'why_choose_us_sub_title'
        ];
        // Create an associative array to map keys to their values
        return SectionTitle::whereIn('key', $keys)->get()->pluck('value', 'key');
    }


    public function showProduct(string $slug):View
    {
        return view('frontend.pages.product-view');
    }

}
