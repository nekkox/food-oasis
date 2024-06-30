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
                <h4>Create Category</h4>
            </div>

            <div class="card-body">

                <form action="{{route('admin.category.store')}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input id="name" name="name" type="text" class="form-control">
                    </div>


                    <div class="form-group">
                        <label for="show_at_home">Show at Home</label>
                        <select id="show_at_home" name="show_at_home" class="form-control">
                            <option value="1">Yes</option>
                            <option selected value="0">No</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>

                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                </form>

            </div>
        </div>
    </section>
@endsection
