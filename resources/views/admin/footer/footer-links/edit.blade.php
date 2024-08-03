@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Edit Footer Link</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Edit Footer Link</h4>

            </div>
            <div class="card-body">
                <form action="{{ route('admin.footer-links.update',$link->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label>Category</label>
                        <select name="category" class="form-control">
                            <option @selected($link->category == "short") value="short">Short Link</option>
                            <option @selected($link->category == "help") value="help">Help Link</option>
                        </select>

                    </div>

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control"  value="{{ $link->name }}">
                    </div>

                    <div class="form-group">
                        <label>Link</label>
                        <input type="text" name="link" class="form-control"  value="{{ $link->link }}">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="">
                            <option @selected($link->status === 1) value="1">Yes</option>
                            <option @selected($link->status === 0) value="0">No</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </section>
@endsection
