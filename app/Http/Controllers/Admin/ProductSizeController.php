<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ProductOption;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $product_id): View
    {
        $product = Product::findOrFail($product_id);
        $sizes = ProductSize::where('product_id', $product->id)->get();
        $options = ProductOption::where('product_id', $product->id)->get();
        return view('admin.product.product-size.index', ['product' => $product, 'sizes' => $sizes, 'options' => $options]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'name'=>['required', 'max:255'],
            'price'=>['required', 'numeric'],
            'product_id'=>['required', 'integer']
        ]);

        $size = new ProductSize();
        $size->product_id = $request->product_id;
        $size->name = $request->name;
        $size->price = $request->price;
        $size->save();

        return redirect()->back()->with('created', true);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $size = ProductSize::findOrFail($id);
            $size->delete();
            return response(['status' => 'success', 'message' => 'Item Deleted Successfully']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' =>'Something went wrong!']);
        }
    }
}
