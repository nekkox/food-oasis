@extends('admin.layouts.master')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Slider</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>All Sliders</h4>
                <div class="card-header-action">
                    <a href="{{route('admin.slider.create')}}" class="btn btn-primary">
                        Create New
                    </a>
                </div>
            </div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </section>
@endsection

@if(session('created'))
    @push('scripts')
        <script>
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Created Successfully",
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endpush
@endif

@if(session('edited'))
    @push('scripts')
        <script>
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Edited Successfully",
                showConfirmButton: false,
                timer: 1500
            });
            //  $('#slider-table').DataTable().draw();
            // toastr.success('done index');


        </script>
    @endpush
@endif

@push('scripts')
    {{--    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js" defer></script>--}}


    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
