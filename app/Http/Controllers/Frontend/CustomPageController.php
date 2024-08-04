<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CustomPageBuilder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CustomPageController extends Controller
{
    /**
     * Handle the incoming request.
     */

    // __invoke magic method allows the class instance to be treated as a callable.
    public function __invoke(string $slug) : View
    {
        $page = CustomPageBuilder::where(['slug' => $slug, 'status' => 1])->firstOrFail();
        return view('frontend.pages.custom-page', ['page' => $page]);
    }
}
