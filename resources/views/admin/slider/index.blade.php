@extends('admin.layouts.master')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Slider</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Card Header</h4>
                <div class="card-header-action">
                    <a href="{{route('admin.slider.create')}}" class="btn btn-primary">
                        Create New
                    </a>
                </div>
            </div>
            <div class="card-body" >
                {{ $dataTable->table() }}
            </div>
        </div>
    </section>



@endsection

{{---@if(session('reload'))

    @push('scripts')

        <script>
            var dataSet = [
                [ "Tiger Nixon", "System Architect", "Edinburgh", "5421", "2011/04/25", "$320,800" ],
                [ "Garrett Winters", "Accountant", "Tokyo", "8422", "2011/07/25", "$170,750" ],
                [ "Ashton Cox", "Junior Technical Author", "San Francisco", "1562", "2009/01/12", "$86,000" ],
                [ "Cedric Kelly", "Senior Javascript Developer", "Edinburgh", "6224", "2012/03/29", "$433,060" ]
            ];

            $(document).ready(function() {
                $('#slider-table').DataTable( {
                    data: dataSet,
                    columns: [
                        { title: "offer" },
                        { title: "title" },
                        { title: "Office" },
                        { title: "Extn." },
                        { title: "Start date" },
                        { title: "Salary" }
                    ]
                } );
            } );
        </script>
    @endpush

@endif--}}


@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js" defer></script>



    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}


@endpush

{{--
@if(session('reload'))
    @push('beginScript')

        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
        <script>
            console.log('beginScript');
            window.location.reload();
        </script>
    @endpush
@else
    @push('scripts')
        <script> console.log('xxxxx');</script>
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @endpush
@endif
--}}
