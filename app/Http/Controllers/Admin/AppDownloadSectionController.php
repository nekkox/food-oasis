<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AppDownloadSectionCreateRequest;
use App\Models\AppDownloadSection;
use App\Traits\FileUploadTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AppDownloadSectionController extends Controller
{
    use FileUploadTrait;

    public function index(){
        $appSection = AppDownloadSection::first();

        return view('admin.app-download-section.index',['appSection'=>$appSection]);
    }

    function store(AppDownloadSectionCreateRequest $request): RedirectResponse
    {

        $imagePath = $this->uploadImage($request, 'image', $request->old_image);
        $backgroundPath = $this->uploadImage($request, 'background', $request->old_background);

        //Model Fillable needed
        AppDownloadSection::updateOrCreate(
            ['id' => 1],
            [
                'image' => !empty($imagePath) ?  $imagePath : $request->old_image,
                'background' => !empty($backgroundPath) ?  $backgroundPath : $request->old_background,
                'title' => $request->title,
                'short_description' => $request->short_description,
                'play_store_link' => $request->play_store_link,
                'apple_store_link' => $request->apple_store_link
            ]

        );



        return to_route('admin.app-download.index')->with('updated', true);
    }
}
