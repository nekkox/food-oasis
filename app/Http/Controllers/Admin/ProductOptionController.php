<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ProductOption;
use Illuminate\Http\Request;

class ProductOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'price' => ['required', 'numeric'],
            'product_id' => ['required', 'integer']
        ], [
                'name. required' => 'Product option name is required',
                'name.max' => 'Product option max length is 255',
                'price.required' => 'Product option price is required',
                'price.numeric' => 'Product option price have to be a number',
            ]

        );
        $option = new ProductOption();
        $option->product_id = $request->product_id;
        $option->name = $request->name;
        $option->price = $request->price;
        $option->save();
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
            $size = ProductOption::findOrFail($id);
            $size->delete();
            return response(['status' => 'success', 'message' => 'Item Deleted Successfully']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' =>'Something went wrong!']);
        }
    }
}
