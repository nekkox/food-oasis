<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminCategoryCreateRequest;
use App\Http\Requests\Admin\AdminCategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.product.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        return view('admin.product.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminCategoryCreateRequest $request):RedirectResponse
    {
        $category = new Category();
        $category->name = $request->name;
        $category->show_at_home=$request->show_at_home;
        $category->status=$request->status;
        $category->slug = Str::slug($request->name);
        $category->save();
        return to_route('admin.category.index')->with('created', true);
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
    public function edit(string $id):View
    {
        $category = Category::findOrFail($id);


        return view('admin.product.category.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminCategoryUpdateRequest $request, string $id)
    {
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->show_at_home=$request->show_at_home;
        $category->status=$request->status;
        $category->slug = Str::slug($request->name);
        $category->save();
        return to_route('admin.category.index')->with('updated', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $WhyChooseUs = Category::findOrFail($id);
            $WhyChooseUs->delete();
            return response(['status' => 'success', 'message' => 'Slider ' . $id . ' Deleted Successfully']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' =>'Something went wrong!']);
        }
    }
}
