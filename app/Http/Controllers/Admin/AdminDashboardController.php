<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderPlacedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index() : View {

        return view('admin.dashboard.index');
       //return view('admin.layouts.master');
    }

    public function clearNotification(){

        $notification = OrderPlacedNotification::query()->update(['seen' => 1]);

        //toastr()->success('Notification Cleared Successfully!');
        return redirect()->back();
    }
}
