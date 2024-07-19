<?php


use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DeliveryAreaController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentGatewaySettingController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\Admin\ProductOptionController;
use App\Http\Controllers\Admin\ProductSizeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\WhyChooseUsController;
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

    /*Why Choose Us Routes*/
    Route::put('why-choose-us-title-update', [WhyChooseUsController::class, 'updateTitle'])->name('why-choose-us-title.update');
    Route::resources(['why-choose-us' => WhyChooseUsController::class]);


    /*Product Category Routes*/
    Route::resources(['category' => CategoryController::class]);

    /*Product Routes*/
    Route::resources(['product' => ProductController::class]);

    /*Product Gallery Routes*/
    Route::get('product-gallery/{product}', [ProductGalleryController::class, 'index'])->name('product-gallery.show-index');
    Route::resources(['product-gallery' => ProductGalleryController::class]);

    /*Product Size Routes*/
    Route::get('product-size/{product}', [ProductSizeController::class, 'index'])->name('product-size.show-index');
    Route::resources(['product-size' => ProductSizeController::class]);

    /*Product Option Routes*/
    Route::resources(['product-option' => ProductOptionController::class]);

    /*Coupon Routes*/
    Route::resources(['coupon' => CouponController::class]);


    /*Product Option Routes*/
    Route::get('/setting',[SettingController::class, 'index'])->name('setting.index');
    Route::put('/general-setting',[SettingController::class, 'UpdateGeneralSetting'])->name('general-setting.update');

    /** Delivery Area Routes */
    Route::resource('delivery-area', DeliveryAreaController::class);

    /** Payment Gateway Setting Routes */
    Route::get('/payment-gateway-setting', [PaymentGatewaySettingController::class, 'index'])->name('payment-setting.index');
    Route::put('/paypal-setting', [PaymentGatewaySettingController::class, 'paypalSettingUpdate'])->name('paypal-setting.update');
    Route::put('/stripe-setting', [PaymentGatewaySettingController::class, 'stripeSettingUpdate'])->name('stripe-setting.update');


    /** Order Routes */
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');

});

/*
 //without using prefix
Route::get('/admin/dashboard',[AdminDashboardController::class, 'index'])->name('admin.dashboard');
*/
