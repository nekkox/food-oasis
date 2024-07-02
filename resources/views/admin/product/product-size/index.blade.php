@extends('admin.layouts.master')

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Products Gallery ({{$product->name}})</h1>
        </div>

        <div>
            <a href="{{route('admin.product.index')}}" class="btn btn-primary my-3">Go Back</a>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>All Images</h4>
            </div>

            <div class="card-body">
                <div class="col-md-8">
                    <form action="{{route('admin.product-gallery.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="file" class="form-control" name="image">
                            <input type="hidden" name="product_id" value="{{ $product->id}}">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="card card-primary">

            {{--<div class="card-body">
                <table class="table table-bordered ">
                    <thead>
                    <th>Image</th>
                    <th>Action</th>
                    </thead>
                    <tbody>
                    @foreach($images as $image)
                        <tr class="container list-group-item-action item">
                            <td style="text-align: center; width: 200px"><img height="100px" src="{{asset($image->image)}}" class="p-2"></td>
                            <td style="position: relative;">
                                <a style="position: absolute; right: 20px"
                                   href='{{route('admin.product-gallery.destroy', $image->id)}}'
                                   class='btn btn-danger delete-item'><i class='fas fa-trash'></i></a>
                            </td>
                        </tr>
                    @endforeach
                    @if(count($images) === 0)
                        <tr>
                            <td class="text-center" colspan="2">No Data Found</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>--}}
        </div>

    </section>
@endsection


