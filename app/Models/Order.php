<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Order extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    public function userAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id','id' );
    }

    public function order_Items(): HasMany
    {
        return $this->HasMany(OrderItem::class);
    }

}
