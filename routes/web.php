<?php

use App\Http\Controllers\Admin\AdminAuthController;

use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\ChatController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\CustomPageController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\ProfileController;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use \App\Events\RTOrderPlacedNotificationEvent;


//Admin Auth Routes
Route::group(['middleware' => 'guest'], function () {
    Route::get('admin/login', [AdminAuthController::class, 'index'])->name('admin.login');
    Route::get('admin/forget-password', [AdminAuthController::class, 'forgetPassword'])->name('admin.forget-password');
});


Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::put('/profile', [\App\Http\Controllers\Frontend\ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\Frontend\ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::post('/profile/avatar', [\App\Http\Controllers\Frontend\ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');

    Route::post('address', [DashboardController::class, 'createAddress'])->name('address.store');
    Route::put('address/{id}/edit', [DashboardController::class, 'updateAddress'])->name('address.update');
    Route::delete('address/{id}', [DashboardController::class, 'destroyAddress'])->name('address.destroy');
});


/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

/*Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});*/


require __DIR__ . '/auth.php';
//require __DIR__ . '/admin.php';

//Show Home page
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/chef', [FrontendController::class, 'chef'])->name('chef');

/** Testimonial page */
Route::get('/testimonials', [FrontendController::class, 'testimonial'])->name('testimonial');

/** About page */
Route::get('/about', [FrontendController::class, 'about'])->name('about');

/** Privacy Policy Routes */
Route::get('/privacy-policy', [FrontendController::class, 'privacyPolicy'])->name('privacy-policy.index');


/** Contact Routes */
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact.index');
Route::post('/contact', [FrontendController::class, 'sendContactMessage'])->name('contact.send-message');


/** Reservation Routes */
Route::post('/reservation', [FrontendController::class, 'reservation'])->name('reservation.store');



/** Newsletter Routes */
Route::post('/subscribe-newsletter', [FrontendController::class, 'subscribeNewsletter'])->name('subscribe-newsletter');

/** Custom Page Routes */
Route::get('/page/{slug}', CustomPageController::class); //invokable controller

/** Product page Route*/
Route::get('/products', [FrontendController::class, 'products'])->name('products.index');

/** Blogs Routes */
Route::get('/blogs', [FrontendController::class, 'blog'])->name('blogs');
Route::get('/blogs/{slug}', [FrontendController::class, 'blogDetails'])->name('blogs.details');
Route::post('/blogs/comment/{blog_id}', [FrontendController::class, 'blogCommentStore'])->name('blogs.comment.store');


//Show Product details page
Route::get('/product/{slug}', [FrontendController::class, 'showProduct'])->name('product.show');

//Product Modal Route
Route::get('/load-product-modal/{productId}', [FrontendController::class, 'loadProductModal'])->name('load-product-modal');

Route::post('product-review', [FrontendController::class, 'productReviewStore'])->name('product-review.store');

//Add to cart route
Route::post('add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
Route::get('get-cart-products', [CartController::class, 'getCartProduct'])->name('get-cart-products');
Route::get('cart-product-remove/{rowId}', [CartController::class, 'cartProductRemove'])->name('cart-product-remove');

/** Wishlist Route */
Route::get('wishlist/{productId}', [WishlistController::class, 'store'])->name('wishlist.store');

//Cart Page Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart-update-qty', [CartController::class, 'cartQtyUpdate'])->name('cart.quantity-update');
Route::get('/cart-destroy', [CartController::class, 'cartDestroy'])->name('cart-destroy');


/** Coupon Routes */
Route::post('/apply-coupon', [FrontendController::class, 'applyCoupon'])->name('apply-coupon');
Route::get('/destroy-coupon', [FrontendController::class, 'destroyCoupon'])->name('destroy-coupon');


Route::group(['middleware' => 'auth'], function () {
    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('checkout/{id}/delivery-cal', [CheckoutController::class, 'CalculateDeliveryCharge'])->name('checkout.delivery-cal');
    Route::post('checkout', [CheckoutController::class, 'checkoutRedirect'])->name('checkout.redirect');


    /** Payment Routes */
    Route::get('payment', [PaymentController::class, 'index'])->name('payment.index');

    Route::post('make-payment', [PaymentController::class, 'makePayment'])->name('make-payment');


    Route::get('payment-success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('payment-cancel', [PaymentController::class, 'paymentCancel'])->name('payment.cancel');

    /** Paypal Routes */
    Route::get('paypal/payment', [PaymentController::class, 'payWithPaypal'])->name('paypal.payment');
    //Paypal returns to this routes if transaction is successful or if transaction is rejected
    Route::get('paypal/success', [PaymentController::class, 'paypalSuccess'])->name('paypal.success');
    Route::get('paypal/cancel', [PaymentController::class, 'paypalCancel'])->name('paypal.cancel');


    /** Stripe Routes */
    Route::get('stripe/payment', [PaymentController::class, 'payWithStripe'])->name('stripe.payment');
    Route::get('stripe/success', [PaymentController::class, 'stripeSuccess'])->name('stripe.success');
    Route::get('stripe/cancel', [PaymentController::class, 'stripeCancel'])->name('stripe.cancel');

    /** Chat Routes */
    Route::post('chat/send-message', [ChatController::class, 'sendMessage'])->name('chat.send-message');
    Route::get('chat/get-conversation/{senderId}', [ChatController::class, 'getConversation'])->name('chat.get-conversation');

});


Route::get('jquery', [\App\Http\Controllers\jq::class, 'index'])->name('jquery');
Route::get('test',
    function () {
        //dd(config('broadcasting'));
        $order = \App\Models\Order::first();
        //dd($order);
        RTOrderPlacedNotificationEvent::dispatch($order);
        // broadcast(new \App\Events\RTOrderPlacedNotificationEvent('hello'));

        return "Event dispatched";
        // return "xxx";
    }
)->name('test');
