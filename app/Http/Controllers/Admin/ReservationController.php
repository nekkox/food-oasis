<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ReservationDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    function index(ReservationDataTable $dataTable) : View|JsonResponse
    {
        return $dataTable->render('admin.reservation.index');
    }
}
