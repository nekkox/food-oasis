<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductCreateRequest;
use App\Http\Requests\Admin\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Traits\FileUploadTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class ProductController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(ProductDataTable $dataTable) : JsonResponse | View
    {

        return $dataTable->render('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::all();

        return view('admin.product.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCreateRequest $request) : RedirectResponse
    {

        // Handle image file */
        $imagePath = $this->uploadImage($request, 'image');

        $product = new Product();

        $product->name = $request->name;
        $product->slug = generateUniqueSlug('Product', $request->name);
        $product->thumb_image = $imagePath;
        $product->category_id = $request->category;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->price = $request->price;
        $product->offer_price = $request->offer_price;
        $product->sku = $request->sku;
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_description;
        $product->show_at_home = $request->show_at_home;
        $product->status = $request->status;
        $product->save();


        return to_route('admin.product.index')->with('created', true);

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
    public function edit(string $id) : View
    {
        $product = Product::findOrFail($id);
        $category = Category::all();

        return view('admin.product.edit',['product'=>$product, 'categories' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, string $id) : RedirectResponse
    {

        $product = Product::findOrFail($id);
        // Handle image file */
        $imagePath = $this->uploadImage($request, 'image',$product->thumb_image);


        $product->name = $request->name;
        //$product->slug = generateUniqueSlug('Product', $request->name);
        $product->slug = $product->slug;

        $product->thumb_image = !empty($imagePath) ? $imagePath : $product->thumb_image;
        $product->category_id = $request->category;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->price = $request->price;
        $product->offer_price = $request->offer_price;
        $product->sku = $request->sku;
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_description;
        $product->show_at_home = $request->show_at_home;
        $product->status = $request->status;
        $product->save();


        return to_route('admin.product.index')->with('updated', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) : Response
    {
        try {
            $product = Product::findOrFail($id);
            $this->removeImage($product->thumb_image);
            $product->delete();
            return response(['status' => 'success', 'message' => 'Slider ' . $id . ' Deleted Successfully']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' =>'Something went wrong!']);
        }
    }
}
