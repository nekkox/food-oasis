<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\About;
use App\Models\Admin\DailyOffer;
use App\Models\AppDownloadSection;
use App\Models\BannerSlider;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\Category;
use App\Models\Chef;
use App\Models\Contact;
use App\Models\Counter;
use App\Models\Coupon;
use App\Models\PrivacyPolicy;
use App\Models\Product;
use App\Models\ProductRating;
use App\Models\Reservation;
use App\Models\SectionTitle;
use App\Models\Slider;
use App\Models\Subscriber;
use App\Models\Testimonial;
use App\Models\WhyChooseUs;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;


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
        $appSection = AppDownloadSection::first();
        $testimonials = Testimonial::where(['show_at_home' => 1, 'status' => 1])->get();
        $counter = Counter::first();
        $latestBlogs = Blog::withCount(['comments' => function ($query) {
            $query->where('status', 1);
        }])->with(['category', 'user'])->where('status', 1)->latest()->take(3)->get();

        // return view('frontend.layouts.master');
        return view('frontend.home.index', [
            'sliders' => $sliders,
            'sectionTitles' => $sectionTitles,
            'whyChooseUs' => $whyChooseUs,
            'categories' => $categories,
            'dailyOffers' => $dailyOffers,
            'bannerSliders' => $bannerSliders,
            'chefs' => $chefs,
            'appSection' => $appSection,
            'testimonials' => $testimonials,
            'counter' => $counter,
            'latestBlogs' => $latestBlogs,
        ]);

    }

    function chef(): View
    {
        $chefs = Chef::where(['status' => 1])->paginate(3);
        return view('frontend.pages.chefs', ['chefs' => $chefs]);
    }

    function testimonial(): View
    {
        $testimonials = Testimonial::where(['status' => 1])->paginate(9);
        return view('frontend.pages.testimonial', ['testimonials' => $testimonials]);
    }

    function about(): View
    {

        $keys = [
            'why_choose_us_top_title',
            'why_choose_us_main_title',
            'why_choose_us_sub_title',
            'chef_top_title',
            'chef_main_title',
            'chef_sub_title',
            'testimonial_top_title',
            'testimonial_main_title',
            'testimonial_sub_title'
        ];

        // Create an associative array to map keys to their values
        $sectionTitles = SectionTitle::whereIn('key', $keys)->get()->pluck('value', 'key');
        $about = About::first();
        $whyChooseUs = WhyChooseUs::where('status', 1)->get();
        $chefs = Chef::where(['show_at_home' => 1, 'status' => 1])->get();
        $counter = Counter::first();
        $testimonials = Testimonial::where(['show_at_home' => 1, 'status' => 1])->get();

        return view('frontend.pages.about', [
            'whyChooseUs' => $whyChooseUs,
            'about' => $about,
            'sectionTitles' => $sectionTitles,
            'chefs' => $chefs,
            'counter' => $counter,
            'testimonials' => $testimonials
            ]);
    }

    function privacyPolicy() : View {
        $privacyPolicy = PrivacyPolicy::first();
        return view('frontend.pages.privacy-policy', ['privacyPolicy' => $privacyPolicy]);
    }

    function contact() : View {
        $contact = Contact::first();
        return view('frontend.pages.contact', ['contact' => $contact]);
    }

    function sendContactMessage(Request $request) {
        $request->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'max:255'],
            'message' => ['required', 'max: 1000']
        ]);

        Mail::send(new ContactMail($request->name, $request->email, $request->subject, $request->message));

        return response(['status' => 'success', 'message' => 'Message Sent Successfully!']);
    }

    function blog(Request $request): View
    {
        /* $blogs = Blog::with(['category', 'user'])->where('status', 1)->latest()->paginate(9);*/
        //$blogs = Blog::with(['category', 'user'])->where('status', 1);
        $blogs = Blog::withCount(['comments' => function ($query) {
            $query->where('status', 1);
        }])->with(['category', 'user'])->where('status', 1);


        if ($request->has('search') && $request->filled('search')) {
            $blogs->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('category') && $request->filled('category')) {

            $blogs->whereHas('category', function ($query) use ($request) {
                $query->where('slug', $request->category);
            });
        }

        $blogs = $blogs->latest()->paginate(9);
        $categories = BlogCategory::where('status', 1)->get();

        return view('frontend.pages.blog', ['blogs' => $blogs, 'categories' => $categories]);
    }

    function blogDetails(string $slug): View
    {

        $blog = Blog::with(['user'])->where('slug', $slug)->where('status', 1)->firstOrFail();

        $latestBlogs = Blog::select('id', 'title', 'slug', 'created_at', 'image')
            ->where('status', 1)
            ->where('id', '!=', $blog->id)
            ->latest()->take(5)->get();

        $categories = BlogCategory::withCount(['blogs' => function ($query) {
            $query->where('status', 1);
        }])->where('status', 1)->get();

        $nextBlog = Blog::select('id', 'title', 'slug', 'image')->where('id', '>', $blog->id)->orderBy('id', 'ASC')->first();
        $previousBlog = Blog::select('id', 'title', 'slug', 'image')->where('id', '<', $blog->id)->orderBy('id', 'DESC')->first();

        $comments = $blog->comments()->where('status', 1)->orderBy('id', 'DESC')->paginate(20);
        $gallery = $blog->gallery;
        return view('frontend.pages.blog-details', ['blog' => $blog, 'latestBlogs' => $latestBlogs, 'categories' => $categories, 'nextBlog' => $nextBlog, 'previousBlog' => $previousBlog, 'comments' => $comments, 'gallery'=>$gallery]);
    }

    public function getSectionTitles(): Collection
    {
        $keys = [
            'why_choose_us_top_title',
            'why_choose_us_main_title',
            'why_choose_us_sub_title',
            'daily_offer_top_title',
            'daily_offer_main_title',
            'daily_offer_sub_title',
            'chef_top_title',
            'chef_main_title',
            'chef_sub_title',
            'testimonial_top_title',
            'testimonial_main_title',
            'testimonial_sub_title'
        ];
        // Create an associative array to map keys to their values
        return SectionTitle::whereIn('key', $keys)->get()->pluck('value', 'key');
    }

    public function showProduct(Request $request , string $slug)
    {
        $product = Product::with(['gallery', 'productSizes', 'productOptions', 'category'])
            ->where(['slug' => $slug, 'status' => 1])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->firstOrFail();

        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(8)
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->latest()
            ->get();

        $reviews = ProductRating::where(['product_id' => $product->id, 'status' => 1])->paginate(10);

        if ($request->ajax()) {
            return view('frontend.pages.ajax.load', ['reviews'=>$reviews])->render();

        }

        return view('frontend.pages.product-view', ['product' => $product, 'relatedProducts' => $relatedProducts, 'reviews'=>$reviews]);
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
            $discount = number_format($subtotal * ($coupon->discount / 100), 2);
        } elseif ($coupon->discount_type === 'amount') {
            $discount = number_format($coupon->discount, 2);
        }

        $finalTotal = $subtotal - $discount;

        session()->put('coupon', ['code' => $code, 'discount' => $discount]);

        return response([
            'discount' => $discount,
            'finalTotal' => $finalTotal,
            'coupon_code' => $code
        ]);
    }

    //destroying a coupon from session
    public function destroyCoupon()
    {
        try {
            session()->forget('coupon');
            return response(['message' => 'Coupon Removed!', 'grand_cart_total' => grandCartTotal()]);
        } catch (\Exception $e) {
            logger($e);
            return response(['message' => 'Something went wrong']);
        }
    }

    function blogCommentStore(Request $request, string $blog_id): RedirectResponse
    {
        $request->validate([
            'comment' => ['required', 'max:500']
        ]);

        Blog::findOrFail($blog_id);

        $comment = new BlogComment();
        $comment->blog_id = $blog_id;
        $comment->user_id = auth()->user()->id;
        $comment->comment = $request->comment;
        $comment->save();

        toastr()->success('Comment submitted successfully and waiting to approve.');
        return redirect()->back();
    }

    function reservation(Request $request)  {
      //  dd($request->all());
        $request->validate([
            'name' => ['required', 'max:255'],
            'phone' => ['required', 'numeric', 'max_digits:50'],
            'date' => ['required', 'date'],
            'time' => ['required'],
            'persons' => ['required', 'numeric',],
            'reservation_time_id' => ['required','numeric']
        ]);

        if(!Auth::check()){
            throw ValidationException::withMessages(['Please Login to Request Reservation']);
        }

        $reservation = new Reservation();
        $reservation->reservation_id = rand(0, 500000);
        $reservation->user_id = auth()->user()->id;
        $reservation->name = $request->name;
        $reservation->phone = $request->phone;
        $reservation->date = $request->date;
        $reservation->time = $request->time;
        $reservation->persons = $request->persons;
        $reservation->reservation_times_id=$request->reservation_time_id;
        $reservation->status = 'pending';
        $reservation->save();

        return response(['status' => 'success', 'message' => 'Request send successfully']);
    }

    function subscribeNewsletter(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:subscribers,email']
        ], ['email.unique' => 'Email is already subscribed!']);

        $subscriber = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->save();

        return response(['status' => 'success', 'message' => 'Subscribed Successfully!']);
    }

    function productReviewStore(Request $request) {
        $request->validate([
            'rating' => ['required', 'min:1', 'max:5', 'integer'],
            'review' => ['required', 'max:500'],
            'product_id' => ['required', 'integer']
        ]);

        $user = Auth::user();
        $hasPurchased = $user->orders()->whereHas('order_items', function($query) use ($request){
            $query->where('product_id', $request->product_id);
        })
            ->where('order_status', 'delivered')
            ->get();

        if(count($hasPurchased) == 0){
            throw ValidationException::withMessages(['Please Buy The Product Before Submit a Review!']);
        }

        //every user can write a review only once
        $alreadyReviewed = ProductRating::where(['user_id' => $user->id, 'product_id' => $request->product_id])->exists();
        if($alreadyReviewed){
            throw ValidationException::withMessages(['You already reviewed this product']);
        }

        $review = new ProductRating();
        $review->user_id = $user->id;
        $review->product_id = $request->product_id;
        $review->rating = $request->rating;
        $review->review = $request->review;
        $review->status = 0;
        $review->save();

        toastr()->success('Review added successfully and waiting to approve');

        return redirect()->back();
    }

    function products(Request $request) : View {
/*        $products = Product::where(['status' => 1])
            ->orderBy('id', 'DESC')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->paginate(12);*/
        $products = Product::where(['status' => 1])->orderBy('id', 'DESC');

        if($request->has('search') && $request->filled('search')) {
            $products->where(function($query) use ($request) {
                $query->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('long_description', 'like', '%'.$request->search.'%');
            });
        }

        if($request->has('category') && $request->filled('category')) {
            $products->whereHas('category', function($query) use ($request){
                $query->where('slug', $request->category);
            });
        }

        $products = $products->withAvg('reviews', 'rating')->withCount('reviews')->paginate(12);
        $categories = Category::where('status', 1)->get();

        return view('frontend.pages.products', compact('products', 'categories'));
    }
}

