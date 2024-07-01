<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

//Create unique slug
if (!function_exists('generateUniqueSlug')) {
    function generateUniqueSlug(string $model, string $name): string
    {

        $modelClass = "App\\Models\\$model";
        if (!class_exists($modelClass)) {
            throw new \InvalidArgumentException("Model $model not found");
        }

        $slug = Str::slug($name);
        $count = 2;

        while ($modelClass::where('slug', $slug)->exists()) {
            $slug = Str::slug($name) . '-' . $count;
            $count++;
        }
        return $slug;
    }

}


