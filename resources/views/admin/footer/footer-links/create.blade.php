@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Footer Link</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Link</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.footer-links.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label>Category</label>
                        <select name="category" class="form-control">
                            <option value="short">Short Link</option>
                            <option value="help">Help Link</option>
                        </select>

                    </div>

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Link</label>
                        <input type="text" name="link" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </section>
@endsection
