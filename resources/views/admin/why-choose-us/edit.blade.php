@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Why Choose Us Section</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Item</h4>
            </div>

            <div class="card-body">

                <form action="{{route('admin.why-choose-us.update', $WhyChooseUs->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label class="mr-2">Icon</label>
                        <button name="icon" class="btn btn-primary" role="iconpicker" data-iconset="fontawesome5"
                                data-icon="{{$WhyChooseUs->icon}}" ></button>
                    </div>

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input id="title" name="title" type="text" class="form-control" value="{{$WhyChooseUs->title}}">
                    </div>


                    <div class="form-group">
                        <label for="short_description">Short Description</label>
                        <textarea id="short_description" name="short_description"
                                  class="form-control">{{$WhyChooseUs->short_description}}</textarea>
                    </div>


                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control">
                            <option @selected($WhyChooseUs->status === 1) value="1">Yes</option>
                            <option @selected($WhyChooseUs->status === 0) value="0">No</option>

                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>

            </div>
        </div>
    </section>
@endsection
