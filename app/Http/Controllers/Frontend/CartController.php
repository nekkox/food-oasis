<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {

        $product = Product::with('productSizes', 'productOptions')->findOrFail($request->product_id);
        $productSize = $product->productSizes->where('id', $request->product_size)->first();
        $productOptions = $product->productOptions->whereIn('id', $request->product_option);


        $options = [
            'product_size' => [
                'id' => $productSize->id,
                'name' => $productSize->name,
                'price' => $productSize->price
            ],
            'product_options' => [

            ]
        ];


        foreach ($productOptions as $productOption) {

            $options['product_options'][] = [
                'id' => $productOption->id,
                'price' => $productOption->price,
                'name' => $productOption->name
            ];
        }


        return response($product);
    }
}
