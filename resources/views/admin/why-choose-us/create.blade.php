@extends('admin.layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>why Choose Us Section</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Item</h4>
            </div>

            <div class="card-body">

                <form action="{{route('admin.why-choose-us.store')}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class="mr-2">Icon</label>
                        <button name="icon" class="btn btn-primary" role="iconpicker"></button>
                    </div>

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input id="title" name="title" type="text" class="form-control">
                    </div>


                    <div class="form-group">
                        <label for="short_description">Short Description</label>
                        <textarea id="short_description" name="short_description"
                                  class="form-control"></textarea>
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
