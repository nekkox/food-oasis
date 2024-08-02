<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\ReservationTime;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;

class StatusUpdater
{
    /**
     * Update the status of the reservation and associated reservation time.
     *
     * @param Reservation $reservation
     * @param string $status
     * @return bool
     */

    protected array $validStatuses = ['approved', 'cancel', 'pending', 'complete'];


    public function updateStatus(Reservation $reservation, string $status): bool
    {
        if (!in_array($status, $this->validStatuses, true)) {
            throw new InvalidArgumentException('Invalid status provided.');
        }

        $reservation->status = $status;
        $reservation->save();

        try {
            $reservationTime = ReservationTime::findOrFail($reservation->id);
        } catch (ModelNotFoundException $e) {
            return false;
        }


        switch ($status) {
            case 'approved':
                $reservationTime->status = 0;
                break;
            case 'cancel':
                $reservationTime->status = 1;
                break;
            case 'pending':
            case 'complete':
                // No changes to reservationTime status for 'pending' or 'complete'
                break;
        }

        $reservationTime->save();
        return true;
    }
}
