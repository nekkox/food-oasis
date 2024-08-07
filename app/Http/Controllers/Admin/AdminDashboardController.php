<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderPlacedNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class AdminDashboardController extends Controller
{
    public function index() : View {

        $todaysOrders = Order::whereDate('created_at', now()->format('Y-m-d'))->count();
        $todaysEarnings = Order::whereDate('created_at', now()->format('Y-m-d'))->where('order_status', 'delivered')->sum('grand_total');

        $thisMonthsOrders = Order::whereMonth('created_at', now()->month)->count();
        $thisMonthsEarnings = Order::whereMonth('created_at', now()->month)->where('order_status', 'delivered')->sum('grand_total');

        $thisYearOrders = Order::whereYear('created_at', now()->year)->count();
        $thisYearEarnings = Order::whereYear('created_at', now()->year)->where('order_status', 'delivered')->sum('grand_total');

        return view('admin.dashboard.index',
            [
                'todaysOrders'=>$todaysOrders,
                'todaysEarnings'=>$todaysEarnings,
                'thisMonthsOrders'=>$thisMonthsOrders,
                'thisMonthsEarnings'=>$thisMonthsEarnings,
                'thisYearOrders'=>$thisYearOrders,
                'thisYearEarnings'=>$thisYearEarnings

            ]
        );

    }

    public function clearNotification(){

        $notification = OrderPlacedNotification::query()->update(['seen' => 1]);

        //toastr()->success('Notification Cleared Successfully!');
        return redirect()->back();
    }
}
