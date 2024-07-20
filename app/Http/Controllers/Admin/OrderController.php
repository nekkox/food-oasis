<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\OrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    function index(OrderDataTable $dataTable) : View | JsonResponse {
        return $dataTable->render('admin.order.index');
    }

    function show($id) : View {
        $order = Order::findOrFail($id);

        return view('admin.order.show', ['order' => $order]);
    }

    function orderStatusUpdate(Request $request, string $id) : RedirectResponse {
        $request->validate([
            'payment_status' => ['required', 'in:pending,completed'],
            'order_status' => ['required', 'in:pending,in_process,delivered,declined']
        ]);

        $order = Order::findOrFail($id);
        $order->payment_status = $request->payment_status;
        $order->order_status = $request->order_status;
        $order->save();

       // toastr()->success('Status Updated Successfully!');

        return redirect()->back()->with('updated', true);

    }

}
