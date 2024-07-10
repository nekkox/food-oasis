<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\ProfileController;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;


//Admin Auth Routes
Route::group(['middleware' => 'guest'], function(){
    Route::get('admin/login', [AdminAuthController::class, 'index'])->name('admin.login');
    Route::get('admin/forget-password', [AdminAuthController::class, 'forgetPassword'])->name('admin.forget-password');
});


Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::put('/profile', [\App\Http\Controllers\Frontend\ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\Frontend\ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::post('/profile/avatar', [\App\Http\Controllers\Frontend\ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');

});


/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
//require __DIR__ . '/admin.php';

//Show Home page
Route::get('/', [FrontendController::class, 'index'])->name('home');

//Show Product details page
Route::get('/product/{slug}', [FrontendController::class, 'showProduct'])->name('product.show');

//Product Modal Route
Route::get('/load-product-modal/{productId}',[FrontendController::class, 'loadProductModal'])->name('load-product-modal');

//Add to cart route
Route::post('add-to-cart',[CartController::class, 'addToCart'])->name('add-to-cart');
Route::get('get-cart-products',[CartController::class, 'getCartProduct'])->name('get-cart-products');
Route::get('cart-product-remove/{rowId}',[CartController::class, 'cartProductRemove'])->name('cart-product-remove');


//Cart Page Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
