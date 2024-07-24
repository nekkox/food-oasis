<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\User;
class Chat extends Model
{
    use HasFactory;


    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        //User-id is local key, sender_id is foreign in Chat table
        return $this->belongsTo(User::class, 'sender_id');

    }
}
