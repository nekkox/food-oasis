<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Reservation extends Model
{
    use HasFactory;

    public function reservationTime() :BelongsTo
    {
        return $this->belongsTo(ReservationTime::class, 'reservation_times_id');

    }
}
