<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DeclinedOrderDataTable;
use App\DataTables\DeliveredOrderDataTable;
use App\DataTables\InProcessOrderDataTable;
use App\DataTables\OrderDataTable;
use App\DataTables\PendingOrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderPlacedNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    function index(OrderDataTable $dataTable) : View | JsonResponse {
        return $dataTable->render('admin.order.index');
    }

    function show($id) : View {
        $order = Order::findOrFail($id);

        //When in Dashboard mode visit the order notification the status is changed to seen 1
        $notification = OrderPlacedNotification::where('order_id', $order->id)->update(['seen'=>1]);


        return view('admin.order.show', ['order' => $order]);
    }

    function orderStatusUpdate(Request $request, string $id) : RedirectResponse | Response {

        $request->validate([
            'payment_status' => ['required', 'in:pending,completed'],
            'order_status' => ['required', 'in:pending,in_process,delivered,declined']
        ]);

        $order = Order::findOrFail($id);
        $order->payment_status = $request->payment_status;
        $order->order_status = $request->order_status;
        $order->save();

        if($request->ajax()){
            return response(['message' => 'Order Status Updated!']);
        }else{
            // toastr()->success('Status Updated Successfully!');

            return redirect()->back()->with('updated', true);
        }
    }

    public function getOrderStatus(string $id) : Response  {
        $order = Order::select(['order_status', 'payment_status'])->findOrFail($id);

        return response($order);
    }

    function destroy(string $id) : Response {
        try{
            $order = Order::findOrFail($id);
            $order->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        }catch(\Exception $e){
            logger($e);
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }


    /*PENDING ORDERS*/
    public function pendingOrderIndex(PendingOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.pending-order-index');
    }

    public function inProcessOrderIndex(InProcessOrderDataTable $dataTable){
        return $dataTable->render('admin.order.inprocess-order-index');
    }

    public function deliveredOrderIndex(DeliveredOrderDataTable $dataTable){
        return $dataTable->render('admin.order.delivered-order-index');
    }
    public function declinedOrderIndex(DeclinedOrderDataTable $dataTable){
        return $dataTable->render('admin.order.declined-order-index');
    }
}
