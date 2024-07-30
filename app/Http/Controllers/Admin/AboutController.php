<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AboutUpdateRequest;
use App\Models\About;
use App\Traits\FileUploadTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    use FileUploadTrait;

    function index() : View {
        $about = About::first();

        return view('admin.about.index', ['about' => $about]);
    }

    function update(AboutUpdateRequest $request): RedirectResponse
    {

        $imagePath = $this->uploadImage($request, 'image', $request->old_image);

        About::updateOrCreate(
            ['id' => 1],
            [
                'image' =>  !empty($imagePath) ? $imagePath : $request->old_image,
                'title' => $request->title,
                'main_title' => $request->main_title,
                'description' => $request->description,
                'video_link' => $request->video_link,

            ]
        );

      //  toastr()->success('Created Successfully');

        return redirect()->back()->with('updated', true);
    }
}
