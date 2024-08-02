<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ReservationTime extends Model
{
    use HasFactory;

    public function reservations():HasOne
    {
        return $this->hasOne(Reservation::class, 'reservation_times_id');
    }
}
