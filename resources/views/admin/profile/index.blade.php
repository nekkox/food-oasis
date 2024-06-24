@extends('admin.layouts.master')
@section('content')

    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Profile</h1>
        </div>

        <div class="section-body">

            <div class="card card-primary">
                <div class="card-header">
                    <h4>Update User Settings</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.profile.update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <div id="image-preview" class="image-preview">
                                <label for="image-upload" id="image-label">Choose File</label>
                                <input type="file" name="image" id="image-upload">
                            </div>
                        </div>


                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{auth()->user()->name}}">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" value="{{auth()->user()->email}}">
                        </div>
                        <button class="btn btn-primary" type="submit">Save</button>

                    </form>
                </div>
            </div>


            <div class="card card-primary">
                <div class="card-header">
                    <h4>Update Password</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.profile.password.update')}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input id="current_password" type="password" name="current_password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input id="password" type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="form-control">
                        </div>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </form>
                </div>
            </div>

        </div>
    </section>

@endsection
@push('scripts')
    <script>
        $(document).ready(function () {

            $('.image-preview').css({
                'background-image': 'url({{ asset(auth()->user()->avatar) }})',
                'background-size': 'cover',
                'background-position': 'center center'
            })
        });
    </script>
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
