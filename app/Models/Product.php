<?php

namespace App\Models;

use App\Models\Admin\ProductOption;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

   // protected $with = ['gallery','productSizes','productOptions'];

    public function gallery(): HasMany
    {
        return $this->HasMany(ProductGallery::class);
    }

    public function category(): BelongsTo
    {
        return $this->BelongsTo(Category::class);
    }

    public function productSizes(): hasMany
    {
        return $this->HasMany(ProductSize::class);
    }

    public function productOptions(): hasMany
    {
        return $this->HasMany(ProductOption::class);
    }

    public function reviews() : HasMany {
        return $this->hasMany(ProductRating::class, 'product_id', 'id');
    }
}
