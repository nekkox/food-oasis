<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Admin\DailyOffer;
use App\Models\BannerSlider;
use App\Models\Category;
use App\Models\Chef;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\SectionTitle;
use App\Models\Slider;
use App\Models\WhyChooseUs;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;


class FrontendController extends Controller
{

    public function index(): View
    {

        //Get all sliders
        $sliders = Slider::where('status', 1)->get();
        $sectionTitles = $this->getSectionTitles();
        $whyChooseUs = WhyChooseUs::where('status', 1)->get();

        $categories = Category::where(['show_at_home' => 1, 'status' => 1])->get();
        $dailyOffers = DailyOffer::with('product')->where('status', 1)->take(15)->get();
        $bannerSliders = BannerSlider::where('status', 1)->latest()->take(10)->get();
        $chefs = Chef::where(['show_at_home' => 1, 'status' => 1])->get();


        // return view('frontend.layouts.master');
        return view('frontend.home.index', [
            'sliders' => $sliders,
            'sectionTitles' => $sectionTitles,
            'whyChooseUs' => $whyChooseUs,
            'categories' => $categories,
            'dailyOffers' => $dailyOffers,
            'bannerSliders' => $bannerSliders,
            'chefs' => $chefs
        ]);

    }

    function chef() : View {
        $chefs = Chef::where(['status' => 1])->paginate(3);
        return view('frontend.pages.chefs', ['chefs'=>$chefs]);
    }

    public function getSectionTitles(): Collection
    {
        $keys = [
            'why_choose_us_top_title',
            'why_choose_us_main_title',
            'why_choose_us_sub_title',
            'daily_offer_top_title',
            'daily_offer_main_title',
            'daily_offer_sub_title'
        ];
        // Create an associative array to map keys to their values
        return SectionTitle::whereIn('key', $keys)->get()->pluck('value', 'key');
    }


    public function showProduct(string $slug): View
    {
        $product = Product::with(['gallery', 'productSizes', 'productOptions', 'category'])->where(['slug' => $slug, 'status' => 1])->firstOrFail();

        $relatedProducts = Product::with('category')->where('category_id', $product->category_id)->where('id', '!=', $product->id)->take(8)->latest()->get();

        return view('frontend.pages.product-view', ['product' => $product, 'relatedProducts' => $relatedProducts]);
    }


    public function loadProductModal(string $productId)
    {
        $product = Product::with('productSizes', 'productOptions')->findOrFail($productId);
        return view('frontend.layouts.ajax-files.product-popup-modal', ['product' => $product])->render();
    }

    /* public function storeCart(Request $request){
         dd($request->all());
     }*/

    public function applyCoupon(Request $request): Response
    {

        $subtotal = $request->subtotal;
        $code = $request->code;

        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return response(['message' => 'Invalid Coupon Code.'], 422);
        }

        if ($coupon->quantity <= 0) {
            return response(['message' => 'Coupon has been fully redeemed.'], 422);
        }

        if ($coupon->expire_date < now()) {
            return response(['message' => 'Coupon has expired.'], 422);
        }

        if ($coupon->discount_type === 'percent') {
            $discount = number_format($subtotal * ($coupon->discount / 100),2);
        } elseif ($coupon->discount_type === 'amount') {
            $discount = number_format($coupon->discount,2);
        }

        $finalTotal = $subtotal - $discount;

        session()->put('coupon', ['code'=>$code, 'discount' => $discount]);

        return response([
            'discount' => $discount,
            'finalTotal' => $finalTotal,
            'coupon_code' => $code
        ]);
    }

    //destroying a coupon from session
    public function destroyCoupon(){
        try{
            session()->forget('coupon');
            return response(['message' => 'Coupon Removed!', 'grand_cart_total' => grandCartTotal()]);
        }catch(\Exception $e){
            logger($e);
            return response(['message' => 'Something went wrong']);
        }
    }
}
