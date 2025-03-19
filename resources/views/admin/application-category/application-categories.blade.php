<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

{{-- @section('title', 'Dashboard') --}}

@section('content')
    <div class="">
        <h1>Add Categories</h1>
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form method="POST" action="{{ route('handle.application-categories') }}" enctype="multipart/form-data">
            @csrf

            <div class="d-flex row">
                @php
                    $fields = [
                        [
                            'name' => 'name',
                            'type' => 'text',
                            'label' => 'Category Name',
                            'placeholder' => 'Enter category name',
                        ],
                        ['name' => 'image', 'type' => 'file', 'label' => 'Category Image', 'placeholder' => ''],
                        ['name' => 'slug', 'type' => 'text', 'label' => 'Slug', 'placeholder' => 'Slug'],
                    ];
                @endphp
                @foreach ($fields as $field)
                    <div class="form-group col-6">
                        <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                        <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" class="form-control"
                            id="{{ $field['name'] }}" placeholder="{{ $field['placeholder'] }}">
                        @error($field['name'])
                            <span class="text-danger ">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach

            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <div class="mt-4">
            <h1>Application Categories</h1>

            <!-- Loading Spinner -->
            <div id="loading-spinner" class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

            <table id="categories-table" class="table table-bordered d-none">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category Name</th>
                        <th>Slug</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($all_categories as $key => $category)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $category['name'] }}</td>
                            <td>{{ $category['slug'] }}</td>
                            <td>
                                <img src="{{ asset(env('APP_URL') . '/' . $category['image']) }}" width="50"
                                    height="50" alt="Category Image">
                            </td>
                            <td>
                                <a href="/edit_category/{{ $category['id'] }}" class="btn btn-warning btn-sm">Edit</a>

                                {{-- <a href="/delele_category/{{ $category['id'] }}" class="btn btn-danger btn-sm">Delete</a> --}}
                                <form action="{{ route('handle.delete-categories', $category['id']) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
