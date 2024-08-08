<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogImages extends Model
{
    use HasFactory;

    public function blog(): BelongsTo
    {
        return $this->BelongsTo(Blog::class,);
    }
}
