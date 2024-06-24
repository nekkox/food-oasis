<?php

namespace App\Traits;

use Illuminate\Http\Request;


trait FileUploadTrait
{
    function uploadImage(Request $request, $inputName, string $path = '/uploads')
    {
        if ($request->hasFile($inputName)) {
            $image = $request->{$inputName};
            $extension = $image->getClientOriginalExtension();
            $imageName = 'media_' . uniqid() . '.' . $extension;
            $image->move(public_path($path), $imageName);
            return $path . '/' . $imageName;
        }
        return null;
    }
}
