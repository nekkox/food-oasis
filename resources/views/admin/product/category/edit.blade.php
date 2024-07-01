@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>
                Product Categories
            </h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Category</h4>
            </div>

            <div class="card-body">

                <form action="{{route('admin.category.update', $category->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input id="name" name="name" type="text" class="form-control" value="{{$category->name}}">
                    </div>


                    <div class="form-group">
                        <label for="show_at_home">Show at Home</label>
                        <select id="show_at_home" name="show_at_home" class="form-control" style="height: 45px;">
                            <option @selected($category->show_at_home === 1) value="1">Yes</option>
                            <option @selected($category->show_at_home === 0)  value="0">No</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control" style="height: 45px;">
                            <option  @selected($category->status === 1) value="1">Active</option>
                            <option @selected($category->status === 0) value="0">Inactive</option>

                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>

            </div>
        </div>
    </section>
@endsection
