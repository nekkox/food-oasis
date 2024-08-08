<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

trait ArrayFileUploadTrait
{
    function uploadImages(Request $request, string $inputName, ?array $oldPaths = null, string $path = 'uploads')
    {
        if ($request->hasFile($inputName)) {
            $images = $request->{$inputName};

            $uploadedPaths = [];

            foreach ($images as $image) {
                $extension = $image->getClientOriginalExtension();
                $imageName = 'media_' . uniqid() . '.' . $extension;
                $image->move(public_path($path), $imageName);

                $uploadedPaths[] = $path . '/' . $imageName;
            }

            // Delete previous files if exist
            if ($oldPaths) {
                foreach ($oldPaths as $oldPath) {
                    if ($oldPath && File::exists(public_path($oldPath))) {
                        File::delete(public_path($oldPath));
                    }
                }
            }

            return $uploadedPaths;
        }

        return null;
    }

    function removeImages(string $path): void
    {
        // Delete previous file if exists
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
