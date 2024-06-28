@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Slider</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Slider</h4>
            </div>

            <div class="card-body">

                <form action="{{route('admin.slider.update', $slider->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group" >
                        <label>Image</label>
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="image" id="image-upload">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="offer">Offer</label>
                        <input id="offer" name="offer" type="text" class="form-control" value="{{$slider->offer}}">
                    </div>

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input id="title" name="title" type="text" class="form-control" value="{{$slider->title}}">
                    </div>

                    <div class="form-group">
                        <label for="sub_title">Sub Title</label>
                        <input id="sub_title" name="sub_title" type="text" class="form-control" value="{{$slider->sub_title}}">
                    </div>

                    <div class="form-group">
                        <label for="short_description">Short Description</label>
                        <textarea id="short_description" name="short_description"
                                  class="form-control" >{{$slider->short_description}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="button_link">Button Link</label>
                        <input id="button_link" name="button_link" type="text" class="form-control" value="{{$slider->button_link}}">
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control" style="height: 100%;">
                            <option @selected($slider->status === 1) value="1">Active</option>
                            <option @selected($slider->status === 0) value="0">Inactive</option>

                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>

            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {

            $('.image-preview').css({
                'background-image': 'url({{ asset($slider->image) }})',
                'background-size': 'cover',
                'background-position': 'center center'
            })
        });
    </script>

@endpush
