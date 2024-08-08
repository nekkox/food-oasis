@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Blog</h1>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Blog</h4>

            </div>
            <div class="card-body">
                <form id="blog-form" action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label>Image</label>
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="image" id="image-upload" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select name="category" class="form-control select2" id="" >
                            <option value="">select</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control summernote" id="">{{ old('description') }}</textarea>
                    </div>


                    {{--QUOTE--}}
                    <div class="card">
                        <div class="card-header">
                            <h4>Quot</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Quot Text</label>
                                <textarea name="quot_description" class="form-control" id="">{{ old('quot_description') }}</textarea>
                            </div>
                            <div class="row">
                            <div class="form-group col-md-6">
                                <label>Author</label>
                                <input type="text" name="quot_author" class="form-control" value="{{ old('quot_author') }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Details</label>
                                <input type="text" name="quot_details" class="form-control" value="{{ old('quot_details') }}">
                            </div>
                            </div>
                        </div>

                    </div>


                    {{--IMAGES--}}

                    <div class="card">
                        <div class="card-header">
                            <h4>Additional Images</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Choose Images</label>
                                <input type="file" name="additional_images[]" id="additional-images" multiple class="form-control-file">
                            </div>
                            <div id="additional-images-preview" class="image-gallery"></div>

                        </div>
                    </div>


                    <div class="form-group">
                        <label>Seo Title</label>
                        <input type="text" name="seo_title" class="form-control" value="{{ old('seo_title') }}">
                    </div>

                    <div class="form-group">
                        <label>Seo Description</label>
                        <textarea name="seo_description" class="form-control" id="">{{ old('seo_description') }}</textarea>
                    </div>


                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" id="">
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

{{--@push('scripts')
    <script>
        $(document).ready(function() {
            // Array to store all selected files
            let selectedFiles = [];

            // Event listener for file selection
            $('#additional-images').on('change', function() {
                // Loop through each newly selected file
                for (let i = 0; i < this.files.length; i++) {
                    // Add each file to the selectedFiles array
                    selectedFiles.push(this.files[i]);
                }

                // Update the image gallery with selected images
                updateImageGallery();
            });

            // Function to update the image gallery
            function updateImageGallery() {
                // Clear previous previews
                $('#additional-images-preview').empty();

                // Loop through selectedFiles array
                selectedFiles.forEach((file, index) => {
                    let reader = new FileReader();

                    // Closure to capture the file information
                    reader.onload = function(e) {
                        // Create a div to hold the image and the close button
                        let imageContainer = $('<div>').addClass('image-container').css({
                            'position': 'relative',
                            'display': 'inline-block',
                            'margin': '5px',
                        });

                        // Create HTML for image preview with height 100px
                        let imagePreview = $('<img>')
                            .addClass('img-thumbnail')
                            .attr('src', e.target.result)
                            .css('max-height', '100px');

                        // Create the "X" button
                        let removeButton = $('<i>')
                            .addClass('fas fa-times')
                            .css({
                                'position': 'absolute',
                                'top': '3px',
                                'right': '5px',
                                'color': '#ff0000',
                                'cursor': 'pointer',
                                'font-size': '25px',

                            })
                            .click(function() {
                                // Remove the file from selectedFiles array
                                selectedFiles.splice(index, 1);
                                // Update the image gallery
                                updateImageGallery();
                            });

                        // Append the image and the button to the container
                        imageContainer.append(imagePreview).append(removeButton);
                        // Append the container to the gallery
                        $('#additional-images-preview').append(imageContainer);
                    };

                    // Read in the image file as a data URL
                    reader.readAsDataURL(file);
                });
            }
        });
    </script>
@endpush--}}
@push('scripts')
    <script>
        $(document).ready(function() {
            var selectedFiles = [];

            // Event listener for file selection
            $('#additional-images').on('change', function() {
                var files = this.files;
               // var newFiles = [];

                for (let i = 0; i < files.length; i++) {
                    if (!selectedFiles.some(file => file.name === files[i].name && file.size === files[i].size)) {
                        selectedFiles.push(files[i]);
                        //newFiles.push(files[i]);
                    }
                }

                // Update the gallery with newly selected files
                updateImageGallery();
                // Clear the file input to avoid resubmitting the same files
                $(this).val('');
            });

            function updateImageGallery() {
                $('#additional-images-preview').empty();
                selectedFiles.forEach((file, index) => {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let imageContainer = $('<div>').addClass('image-container').css({
                            'position': 'relative',
                            'display': 'inline-block',
                            'margin': '5px',
                        });

                        let imagePreview = $('<img>')
                            .addClass('img-thumbnail')
                            .attr('src', e.target.result)
                            .css('max-height', '100px');

                        let removeButton = $('<i>')
                            .addClass('fas fa-times')
                            .css({
                                'position': 'absolute',
                                'top': '3px',
                                'right': '5px',
                                'color': '#ff0000',
                                'cursor': 'pointer',
                                'font-size': '25px',
                            })
                            .click(function() {
                                // Remove the file from the selectedFiles array
                                selectedFiles = selectedFiles.filter((f, i) => i !== index);
                                // Update the gallery
                                updateImageGallery();
                            });

                        imageContainer.append(imagePreview).append(removeButton);
                        $('#additional-images-preview').append(imageContainer);
                    };
                    reader.readAsDataURL(file);
                });
            }

            // Handle form submission
            $('#blog-form').on('submit', function(event) {
                event.preventDefault(); // Prevent default form submission

                // Create a new FormData object
                let formData = new FormData(this);

                // Append files from selectedFiles array to FormData object
                selectedFiles.forEach(file => {
                    formData.append('additional_images[]', file);
                });

                // Submit the form data using AJAX
                $.ajax({
                    url: $(this).attr('action'), // Use form's action attribute
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Handle success
                        window.location.href = response.redirect;

                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        alert('An error occurred: ' + error);
                    }
                });
            });
        });
    </script>
@endpush
