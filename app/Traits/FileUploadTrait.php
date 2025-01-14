<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


trait FileUploadTrait
{
    function uploadImage(Request $request, string $inputName, string $oldPath = null,  string $path = 'uploads')
    {
        if ($request->hasFile($inputName)) {

            $image = $request->{$inputName};
            $extension = $image->getClientOriginalExtension();
            $imageName = 'media_' . uniqid() . '.' . $extension;
            $image->move(public_path($path), $imageName);

            //Delete previouss file if exist
            if($oldPath && File::exists(public_path($oldPath))){
                File::delete(public_path($oldPath));

            }

            return $path . '/' . $imageName;

        }
        return null;
    }

    function removeImage(string $path): void
    {
        //Delete previouss file if exist
        if(File::exists(public_path($path))){
            File::delete(public_path($path));
        }
    }
}
