<?php


use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\AppDownloadSectionController;
use App\Http\Controllers\Admin\BannerSliderController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\ChefController;
use App\Http\Controllers\Admin\ClearDatabaseController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CounterController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomPageBuilderController;
use App\Http\Controllers\Admin\DailyOfferController;
use App\Http\Controllers\Admin\DeliveryAreaController;
use App\Http\Controllers\Admin\FooterInfoController;
use App\Http\Controllers\Admin\FooterLinkController;
use App\Http\Controllers\Admin\MenuBuilderController;
use App\Http\Controllers\Admin\NewsLetterController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentGatewaySettingController;
use App\Http\Controllers\Admin\PrivacyPolicyController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\Admin\ProductOptionController;
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\ProductSizeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\ReservationTimeController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\SocialLinkController;
use App\Http\Controllers\Admin\TestimonialController;
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

    /** Product Reviews Routes */
    Route::get('product-reviews', [ProductReviewController::class, 'index'])->name('product-reviews.index');
    Route::post('product-reviews', [ProductReviewController::class, 'updateStatus'])->name('product-reviews.update');
    Route::delete('product-reviews/{id}', [ProductReviewController::class, 'destroy'])->name('product-reviews.destroy');


    /*Coupon Routes*/
    Route::resources(['coupon' => CouponController::class]);


    /*Setting Routes*/
    Route::get('/setting',[SettingController::class, 'index'])->name('setting.index');
    Route::put('/general-setting',[SettingController::class, 'UpdateGeneralSetting'])->name('general-setting.update');
    Route::put('/pusher-setting', [SettingController::class, 'UpdatePusherSetting'])->name('pusher-setting.update');
    Route::put('/mail-setting', [SettingController::class, 'UpdateMailSetting'])->name('mail-setting.update');
    Route::put('/logo-setting', [SettingController::class, 'UpdateLogoSetting'])->name('logo-setting.update');
    Route::put('/appearance-setting', [SettingController::class, 'UpdateAppearanceSetting'])->name('appearance-setting.update');
    Route::put('/seo-setting', [SettingController::class, 'UpdateSeoSetting'])->name('seo-setting.update');

    /** Delivery Area Routes */
    Route::resource('delivery-area', DeliveryAreaController::class);

    /** Payment Gateway Setting Routes */
    Route::get('/payment-gateway-setting', [PaymentGatewaySettingController::class, 'index'])->name('payment-setting.index');
    Route::put('/paypal-setting', [PaymentGatewaySettingController::class, 'paypalSettingUpdate'])->name('paypal-setting.update');
    Route::put('/stripe-setting', [PaymentGatewaySettingController::class, 'stripeSettingUpdate'])->name('stripe-setting.update');


    /** Order Routes */
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('orders/status-update/{id}', [OrderController::class, 'orderStatusUpdate'])->name('orders.status-update');
    Route::get('orders/status/{id}', [OrderController::class, 'getOrderStatus'])->name('orders.status');
    Route::delete('orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');


    /*Order Stats Routes*/
    Route::get('pending-orders', [OrderController::class, 'pendingOrderIndex'])->name('pending-orders');
    Route::get('inprocess-orders', [OrderController::class, 'inProcessOrderIndex'])->name('inprocess-orders');
    Route::get('delivered-orders', [OrderController::class, 'deliveredOrderIndex'])->name('delivered-orders');
    Route::get('declined-orders', [OrderController::class, 'declinedOrderIndex'])->name('declined-orders');


    /*Order Notification Route*/
    Route::get('clear-notification',[AdminDashboardController::class, 'clearNotification'])->name('clear-notification');

    /** chat Routes */
    Route::get('chat',[ChatController::class, 'index'])->name('chat.index');
    Route::get('chat/get-conversation/{senderId}',[ChatController::class, 'getConversation'])->name('chat.get-conversation');
    Route::post('chat/send-message', [ChatController::class, 'sendMessage'])->name('chat.send-message');


    /** Daily Offer Routes */
    Route::get('daily-offer/search-product', [DailyOfferController::class, 'productSearch'])->name('daily-offer.search-product');
    Route::put('daily-offer-title-update', [DailyOfferController::class, 'updateTitle'])->name('daily-offer-title-update');

    Route::resource('daily-offer', DailyOfferController::class);


    /** Banner Slider Routes */
    Route::resource('banner-slider', BannerSliderController::class);

    /** Chef Routes */
    Route::put('chefs-title-update', [ChefController::class, 'updateTitle'])->name('chefs-title-update');
    Route::resource('chefs', ChefController::class);

    /** App Download Routes */
    Route::get('app-download', [AppDownloadSectionController::class, 'index'])->name('app-download.index');
    Route::post('app-download', [AppDownloadSectionController::class, 'store'])->name('app-download.store');

    /** Testimonial Routes */
    Route::put('testimonial-title-update', [TestimonialController::class, 'updateTitle'])->name('testimonial-title-update');
    Route::resource('testimonial', TestimonialController::class);

    /** Counter Routes */
    Route::get('counter', [CounterController::class, 'index'])->name('counter.index');
    Route::put('counter', [CounterController::class, 'update'])->name('counter.update');


    /** Blogs Routes */
    Route::resource('blog-category', BlogCategoryController::class);
    Route::get('blogs/comments', [BlogController::class, 'blogComment'])->name('blogs.comments.index');
    Route::get('blogs/comments/{id}', [BlogController::class, 'commentStatusUpdate'])->name('blogs.comments.update');
    Route::delete('blogs/comments/{id}', [BlogController::class, 'commentDestroy'])->name('blogs.comments.destroy');

    Route::resource('blogs', BlogController::class);


    /** About Routes */
    Route::get('about', [AboutController::class, 'index'])->name('about.index');
    Route::put('about', [AboutController::class, 'update'])->name('about.update');



    /** Privacy Policy Routes */
    Route::get('privacy-policy', [PrivacyPolicyController::class, 'index'])->name('privacy-policy.index');
    Route::put('privacy-policy', [PrivacyPolicyController::class, 'update'])->name('privacy-policy.update');

    /** Contact Routes */
    Route::get('contact', [ContactController::class, 'index'])->name('contact.index');
    Route::put('contact', [ContactController::class, 'update'])->name('contact.update');

    /** Reservation Routes */
    Route::resource('reservation-time', ReservationTimeController::class);
    Route::get('reservation', [ReservationController::class, 'index'])->name('reservation.index');
    Route::post('reservation', [ReservationController::class, 'update'])->name('reservation.update');
    Route::delete('reservation/{id}', [ReservationController::class, 'destroy'])->name('reservation.destroy');

    /** News letter Routes */
    Route::get('news-letter', [NewsLetterController::class, 'index'])->name('news-letter.index');
    Route::post('news-letter', [NewsLetterController::class, 'sendNewsLetter'])->name('news-letter.send');


    /** Social Links Routes */
    Route::resource('social-link', SocialLinkController::class);

    /** Footer Routes */
    Route::get('footer-info', [FooterInfoController::class, 'index'])->name('footer-info.index');
    Route::put('footer-info', [FooterInfoController::class, 'update'])->name('footer-info.update');
    Route::resource('footer-links', FooterLinkController::class);

    /** Menu builder Routes */
    Route::get('menu-builder', [MenuBuilderController::class, 'index'])->name('menu-builder.index');

    /** Custom page builder Routes */
    Route::resource('custom-page-builder', CustomPageBuilderController::class);

    /** Admin management Routes */
    Route::resource('admin-management', AdminManagementController::class);

    /** Clear Database Routes */
    Route::get('/clear-database', [ClearDatabaseController::class, 'index'])->name('clear-database.index');
    Route::post('/clear-database', [ClearDatabaseController::class, 'clearDB'])->name('clear-database.destroy');
});

/*
 //without using prefix
Route::get('/admin/dashboard',[AdminDashboardController::class, 'index'])->name('admin.dashboard');
*/
