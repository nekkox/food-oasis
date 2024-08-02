<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ReservationDataTable;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\ReservationTime;
use App\Services\StatusUpdater;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReservationController extends Controller
{
    protected $statusUpdater;

    public function __construct(StatusUpdater $statusUpdater)
    {
        $this->statusUpdater = $statusUpdater;
    }


    function index(ReservationDataTable $dataTable) : View|JsonResponse
    {
        //dd(ReservationTime::with('reservations')->where('id',1)->get());
        return $dataTable->render('admin.reservation.index');
    }

    function update(Request $request) : Response {
        $reservation = Reservation::findOrFail($request->id);
        $reservation->status = $request->status;
        $reservation->save();


        if ($this->statusUpdater->updateStatus($reservation, $request->status)) {
            return response(['status' => 'success', 'message' => 'Updated successfully!']);
        } else {
            return response(['status' => 'error', 'message' => 'Failed to update status!'], 400);
        }
/*        if($reservation->status === 'approved'){
           $reservationTime = ReservationTime::findOrFail($reservation->id);

            $reservationTime->status=0;
            $reservationTime->save();
        }

        if($reservation->status === 'cancel'){
            $reservationTime = ReservationTime::findOrFail($reservation->id);

            $reservationTime->status=1;
            $reservationTime->save();
        }*/

      //  return response(['status' => 'success', 'message' => 'updated successfully!']);
    }

    function destroy(string $id) : Response {
        try {
            $reservation = Reservation::findOrFail($id);
            $reservation->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
