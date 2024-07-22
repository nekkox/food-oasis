
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>{{ config('settings.site_name') }} | Dashboard</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('admin/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/modules/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin/assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap-iconpicker.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/components.css') }}">

    <script>
        var pusherKey = "{{config('settings.pusher_key')}}";
        var pusherCluster = "{{config('settings.pusher_cluster')}}";
    </script>
@vite(['resources/js/app.js'])
</head>

<body>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>

        @include('admin.layouts.sidebar')

        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
        <footer class="main-footer">
            <div class="footer-left">
                Copyright &copy; 2024
                <div class="bullet"></div>
                Design By Nekkox
            </div>
            <div class="footer-right">

            </div>
        </footer>
    </div>
</div>



<!-- General JS Scripts -->
<script src="{{ asset('admin/assets/modules/jquery.min.js') }}"></script>
<script src="{{ asset('admin/assets/modules/popper.js') }}"></script>
<script src="{{ asset('admin/assets/modules/tooltip.js') }}"></script>
<script src="{{ asset('admin/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('admin/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/stisla.js') }}"></script>

<script src="{{ asset('admin/assets/js/toastr.min.js') }}"></script>
<script src="{{ asset('admin/assets/modules/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/bootstrap-iconpicker.bundle.min.js') }}"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('admin/assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('admin/assets/modules/summernote/summernote-bs4.js') }}"></script>
<script src="{{ asset('admin/assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('admin/assets/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('admin/assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<!-- Template JS File -->
<script src="{{ asset('admin/assets/js/scripts.js') }}"></script>
<script src="{{ asset('admin/assets/js/custom.js') }}"></script>




<!--show dynamic validation message-->
<script>
    toastr.options.positionClass = "toast-bottom-right"
    @if($errors->any())
    @foreach($errors->all() as $error)
    toastr.error("{{$error}}")
    @endforeach
    @endif
</script>

<script>
    $.uploadPreview({
        input_field: "#image-upload", // Default: .image-upload
        preview_box: "#image-preview", // Default: .image-preview
        label_field: "#image-label", // Default: .image-label
        label_default: "Choose File", // Default: Choose File
        label_selected: "Change File", // Default: Change File
        no_label: false, // Default: false
        success_callback: null // Default: null
    });
</script>

<script>
    $(document).ready(function () {

        //Action when Element is DELETED
        $('body').on('click', '.delete-item', function (e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let item = $(this).closest('.item'); // Assuming each deletable item has a class 'item'

            console.log(url);
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: url,
                        method: 'DELETE',
                        data: {
                            _token: "{{csrf_token()}}"
                            // "_token": $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                console.log('deleted');
                                toastr.success(response.message);
                                item.remove(); // Remove the deleted item from the DOM
                                $('#product-table').DataTable().draw();
                                $('#slider-table').DataTable().draw();
                                $('#coupon-table').DataTable().draw();
                                $('#order-table').DataTable().draw();


                            } else if (response.status === 'error') {
                                toastr.error(response.message)
                            }
                        },
                        error: function (error) {
                            console.log(error);
                        },
                        complete: function () {

                        }
                    });
                }
            });
        })
    });
</script>

<script>
    @if(session('updated'))

    Swal.fire({
        position: "center",
        icon: "success",
        title: "Updated Successfully",
        showConfirmButton: false,
        timer: 1500
    });


@endif
</script>
<script>
    @if(session('created'))

    Swal.fire({
        position: "center",
        icon: "success",
        title: "Created Successfully",
        showConfirmButton: false,
        timer: 1500
    });


    @endif
</script>
{{--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js" defer></script>--}}




{{--@if(session('reload'))
    <script>
        $(document).ready(function () {
          //  $('#slider-table').DataTable().draw();
            toastr.success('done');
        })

    </script>

--}}{{--
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js" defer></script>

<script>
    $('#slider-table').DataTable().draw();
    toastr.success('done');
</script>--}}{{--
@endif--}}


{{--
<script>
    @if(session('reload'))
    console.log('reloaded');


//window.location.reload();
 $('#slider-table').DataTable().draw();
    toastr.success('done');
    @endif
</script>--}}

@stack('scripts')

</body>
</html>

