@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Why Choose Us</h1>
        </div>
{{--        <div class="card card-primary">
            <div class="card-header">
                <h4>All Items</h4>
            </div>
            <div class="card-body">

            </div>
        </div>--}}

        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div id="accordion">
                        <div class="accordion">
                            <div class="accordion-header bg-primary text-light p-3" role="button" data-toggle="collapse" data-target="#panel-body-1" aria-expanded="true">
                                <h4>Why Choose Us Section Titles </h4>
                            </div>
                            <div class="accordion-body collapse show" id="panel-body-1" data-parent="#accordion">
                               <form action="{{route('admin.why-choose-us-title.update')}}" method="post">
                                   @csrf
                                   @method('put')
                                   <div class="form-group">
                                       <label for="">Top Title</label>
                                       <input type="text" class="form-control" name="why_choose_us_top_title" value="{{$titles['why_choose_us_top_title'] ?? ''}}">
                                   </div>
                                   <div class="form-group">
                                       <label for="">Main Title</label>
                                       <input type="text" class="form-control" name="why_choose_us_main_title" value="{{$titles['why_choose_us_main_title'] ?? ''}}">
                                   </div>
                                   <div class="form-group">
                                       <label for="">Sub Title</label>
                                       <input type="text" class="form-control" name="why_choose_us_sub_title" value="{{@$titles['why_choose_us_sub_title']}}">
                                   </div>
                                   <button type="submit" class="btn btn-primary">Save</button>
                               </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>


    <section class="section">

        <div class="card card-primary">
            <div class="card-header">
                <h4>All Items</h4>
                <div class="card-header-action">
                    <a href="{{route('admin.why-choose-us.create')}}" class="btn btn-primary">
                        Create New
                    </a>
                </div>
            </div>
            <div class="card-body">
                {{$dataTable->table() }}
            </div>
        </div>
    </section>
@endsection

@if(session('titleUpdated'))
    @push('scripts')
        <script>
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Updated Successfully",
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endpush
@endif


@push('scripts')
    {{--    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js" defer></script>--}}


    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
