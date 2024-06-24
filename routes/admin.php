<?php


use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    //middleware for this admin routes is added globally in RouteServiceProvider
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    /*Profile Routes*/
    Route::get('profile',[ProfileController::class, 'index'])->name('profile');
});

/*
 //without using prefix
Route::get('/admin/dashboard',[AdminDashboardController::class, 'index'])->name('admin.dashboard');
*/
