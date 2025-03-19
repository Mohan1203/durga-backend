<!-- resources/views/admin/users.blade.php -->
@extends('layouts.admin')

@section('title', 'Users')

@section('content')
    <div class="">
        <div class="page-header">
            <h3 class="page-title">
                Manage Application Products
            </h3>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            Edit Application Products
                        </h4>

                        <form class="pt-3 class-create-form" id="create-form"
                            action="{{ route('events-and-news.update', $events->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">

                                    <label>Name <span class="text-danger">*</span></label>
                                    <input name="name" type="text" placeholder="Enter Product Name"
                                        class="form-control" value={{ old('name', $events->name) }} />
                                    @error('name')
                                        <span class="text-danger mt-5">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label for="image">Image</label>
                                    <div class="d-flex flex-column gap-2">
                                        <div class="d-flex flex-column">
                                            <input type="file" name="image" class="form-control" id="imageInput">
                                        </div>
                                        <div id="imageContainer" class="">
                                            @if ($events->image)
                                                <img id="previewImage"
                                                    src="{{ asset(env('APP_URL') . '/' . $events->image) }}"
                                                    class=" img-thumbnail">
                                            @else
                                                <img id="previewImage" src=""
                                                    class="h-100 w-100 img-thumbnail d-none">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    @endsection
