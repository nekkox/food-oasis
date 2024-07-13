<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{

    public function index(): View
    {
        return view('frontend.pages.cart-view');
    }


    public function addToCart(Request $request)
    {
        //dd($request->all());
        $product = Product::with('productSizes', 'productOptions')->findOrFail($request->product_id);
        if ($product->quantity < $request->quantity) {
            throw ValidationException::withMessages(['Quantity is not available']);
        }
        try {
            $productSize = $product->productSizes->where('id', $request->product_size)->first();
            $productOptions = $product->productOptions->whereIn('id', $request->product_option);


            $options = [
                'product_size' => [],
                'product_options' => [],
                'product_info' => [
                    'image' => $product->thumb_image,
                    'slug' => $product->slug
                ]
            ];

            if ($productSize !== null) {
                $options['product_size'] = [
                    'id' => $productSize?->id,
                    'name' => $productSize?->name,
                    'price' => $productSize?->price
                ];
            }

            foreach ($productOptions as $productOption) {

                $options['product_options'][] = [
                    'id' => $productOption->id,
                    'price' => $productOption->price,
                    'name' => $productOption->name
                ];
            }


            // Add the product to the cart
            Cart::add(
                $product->id,
                $product->name,
                $request->quantity,
                $product->offer_price > 0 ? $product->offer_price : $product->price,
                0,
                $options
            );

            return response(['status' => 'success', 'message' => 'Product added onto cart!'], 200);
        } catch (\Exception $e) {

            return response(['status' => 'error', 'message' => 'something went wrong!'], 500);

        }
    }


    public function getCartProduct()
    {
        return view('frontend.layouts.ajax-files.sidebar-cart-item')->render();
    }


    public function cartProductRemove($rowId)
    {
        try {
            Cart::remove($rowId);
            return response([
                'status' => 'success',
                'message' => 'Item has been removed!',
                'cart_total' => cartTotal(),
                'grand_cart_total' => grandCartTotal()
            ], 200);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'Something went wrong'], 500);
        }
    }

    public function cartQtyUpdate(Request $request)
    {
        //dd($request->all());
        $cartItem = Cart::get($request->rowId);
        // dd($item );
        $product = Product::findOrFail($cartItem->id);
        // dd($product);
        if ($product->quantity < $request->qty) {
            return response([
                'status' => 'error',
                'message' => 'Quantity is not available',
                'qty' => $cartItem->qty,
            ],
                200);
        }

        try {
            $cart = Cart::update($request->rowId, $request->qty);
            return response([
                'status' => 'success',
                'product_total' => productTotal($request->rowId),
                'qty' => $cart->qty,
                'cart_total' => cartTotal(),
                'grand_cart_total' => grandCartTotal()
            ], 200);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'Something went wrong, please reload the page'], 500);

        }
    }

    public function cartDestroy()
    {
        Cart::destroy();
        session()->forget('coupon');
        return redirect()->back();
    }
}
