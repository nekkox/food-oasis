<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BlogCategoryDataTable;
use App\DataTables\BlogCommentDataTable;
use App\DataTables\BlogDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogCreateRequest;
use App\Http\Requests\Admin\BlogUpdateRequest;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\BlogImages;
use App\Traits\ArrayFileUploadTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    use FileUploadTrait;
    use ArrayFileUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(BlogDataTable $dataTable): View|JsonResponse
    {


        return $dataTable->render('admin.blog.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.blog.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogCreateRequest $request)
    {
        //dd($request->additional_images);
        $imagePath = $this->uploadImage($request, 'image');

        $blog = new Blog();
        $blog->user_id = auth()->user()->id;
        $blog->image = $imagePath;
        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title);
        $blog->category_id = $request->category;
        $blog->description = $request->description;
        $blog->quot_description = $request->quot_description;
        $blog->quot_author = $request->quot_author;
        $blog->quot_details = $request->quot_details;
        $blog->seo_title = $request->seo_title;
        $blog->seo_description = $request->seo_description;
        $blog->status = $request->status;
        $blog->save();

        // Assuming 'additional_images' is an array of uploaded files
        $additionalImages = $request->file('additional_images');


        $oldPaths = []; // If you have old paths of images to delete

        $uploadedPaths = $this->uploadImages($request, 'additional_images', $oldPaths);
        foreach ($uploadedPaths as $path) {
            $blogImage = new BlogImages();
            $blogImage->blog_id = $blog->id;
            $blogImage->image_path = $path;
            $blogImage->save();
        }

        return response(['status' => 'success', 'redirect' => route('admin.blogs.index')]);
        //  return to_route('admin.blogs.index')->with('created', true);
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
    public function edit(string $id): View
    {
        $blog = Blog::findOrFail($id);
        $categories = BlogCategory::all();
        return view('admin.blog.edit', ['blog' => $blog, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogUpdateRequest $request, string $id): RedirectResponse
    {

        $imagePath = $this->uploadImage($request, 'image', $request->old_image);

        $blog = Blog::findOrFail($id);
        $blog->image = !empty($imagePath) ? $imagePath : $request->old_image;
        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title);
        $blog->category_id = $request->category;
        $blog->description = $request->description;
        $blog->seo_title = $request->seo_title;
        $blog->seo_description = $request->seo_description;
        $blog->status = $request->status;
        $blog->save();

        //toastr()->success('Created Successfully');

        return to_route('admin.blogs.index')->with('updated', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {

        try {
            $blog = Blog::findOrFail($id);
            foreach ($blog->gallery as $item){
                $this->removeImage($item->image_path);
            }
            $this->removeImage($blog->image);

            $blog->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }

    function blogComment(BlogCommentDataTable $dataTable): View|JsonResponse
    {

        return $dataTable->render('admin.blog.blog-comment.index');
    }

    function commentStatusUpdate(string $id): RedirectResponse
    {
        $comment = BlogComment::find($id);

        $comment->status = !$comment->status;
        $comment->save();

        // toastr()->success('Updated Successfully');
        return redirect()->back()->with('updated', true);
    }

    function commentDestroy(string $id): Response
    {
        try {
            $comment = BlogComment::findOrFail($id);
            $comment->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
