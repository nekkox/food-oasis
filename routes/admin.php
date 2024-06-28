<?php


use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SliderController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    //middleware for this admin routes is added globally in RouteServiceProvider
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    /*Profile Routes*/
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    /*Slider Routes*/
    Route::resources([
        'slider' => SliderController::class,
    ]);

    Route::get('/slider/all', [SliderController::class, 'allItems']);

    /*Route::get('slider',[SliderController::class, 'index'])->name('slider.index');
    Route::get('slider/create',[SliderController::class, 'create'])->name('slider.create');
    Route::post('slider',[SliderController::class, 'store'])->name('slider.store');
    Route::get('slider/edit/{id}',[SliderController::class, 'edit'])->name('slider.edit');
    Route::put('slider/update/{id}',[SliderController::class, 'update'])->name('slider.update');*/

});

/*
 //without using prefix
Route::get('/admin/dashboard',[AdminDashboardController::class, 'index'])->name('admin.dashboard');
*/
