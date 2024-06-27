@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Create Slider</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Slider</h4>
            </div>

            <div class="card-body">

                <form action="{{route('admin.slider.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group" >
                        <label>Image</label>
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="image" id="image-upload">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="offer">Offer</label>
                        <input id="offer" name="offer" type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input id="title" name="title" type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="sub_title">Sub Title</label>
                        <input id="sub_title" name="sub_title" type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="short_description">Short Description</label>
                        <textarea id="short_description" name="short_description"
                                  class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="button_link">Button Link</label>
                        <input id="button_link" name="button_link" type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control">
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

@push('scripts')

        <script>
            //jquery plugin implemented to the backend
            $.uploadPreview({
                input_field: "#image-upload",   // Default: .image-upload
                preview_box: "#image-preview",  // Default: .image-preview
                label_field: "#image-label",    // Default: .image-label
                label_default: "Choose File",   // Default: Choose File
                label_selected: "Change File",  // Default: Change File
                no_label: false,                // Default: false
                success_callback: null          // Default: null
            });
        </script>

@endpush
