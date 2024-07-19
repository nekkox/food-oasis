<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\OrderDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    function index(OrderDataTable $dataTable) : View {
        return $dataTable->render('admin.order.index');
    }
}
