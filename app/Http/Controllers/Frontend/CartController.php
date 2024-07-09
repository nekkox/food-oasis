<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        try {
            $product = Product::with('productSizes', 'productOptions')->findOrFail($request->product_id);
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

}
