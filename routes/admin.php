<?php


use App\Http\Controllers\Admin\AdminDashboardController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    //middleware for this admin routes is added globally in RouteServiceProvider
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
});

/*
 //without using prefix
Route::get('/admin/dashboard',[AdminDashboardController::class, 'index'])->name('admin.dashboard');
*/
