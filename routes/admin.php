<?php


use App\Http\Controllers\Admin\AdminDashboardController;
use Illuminate\Support\Facades\Route;

//middleware for this admin routes is added globally in RouteServiceProvider
Route::get('/admin/dashboard',[AdminDashboardController::class, 'index'])->name('admin.dashboard');
