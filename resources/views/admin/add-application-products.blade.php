@extends('layouts.admin')

@section('content')
    <h1 class="text-2xl font-bold">Application Products</h1>
    <form method="POST" enctype="multipart/form-data" action="{{ route('handle.add-application-products') }}">
        @csrf
        <div class="row">
            @php
                $fields = [
                    [
                        'name' => 'name',
                        'type' => 'text',
                        'label' => 'Product Name',
                        'placeholder' => 'Enter product name',
                    ],
                    [
                        'name' => 'category_id',
                        'type' => 'select',
                        'label' => 'Category',
                        'placeholder' => 'Select Category',
                    ],
                    ['name' => 'slug', 'type' => 'text', 'label' => 'Slug', 'placeholder' => 'Slug'],
                    ['name' => 'image', 'type' => 'file', 'label' => 'Product Image', 'placeholder' => ''],
                    [
                        'name' => 'description',
                        'type' => 'textarea',
                        'label' => 'Description',
                        'placeholder' => 'Description',
                    ],

                    ['name' => 'feature', 'type' => 'text', 'label' => 'Feature', 'placeholder' => 'Feature'],
                ];
            @endphp

            @foreach ($fields as $field)
                <div class="col-md-6 mb-3">
                    <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                    @if ($field['type'] == 'textarea')
                        <textarea name="{{ $field['name'] }}" class="form-control" id="{{ $field['name'] }}"
                            placeholder="{{ $field['placeholder'] }}" rows="5"></textarea>
                    @elseif($field['type'] == 'select')
                        <select name="category_id" id="category_id" class="form-control p-3">
                            <option value="">Select Category</option>
                            @foreach ($all_categories as $category)
                                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                            @endforeach
                        </select>
                    @elseif($field['name'] == 'feature')
                        <div class="row">
                            <div class="col-10">
                                <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" class="form-control"
                                    id="{{ $field['name'] }}" placeholder="{{ $field['placeholder'] }}">
                            </div>
                            <div class="col-2">
                                <button class="btn btn-primary" type="button" id="feature-add-btn">Add</button>
                            </div>
                        </div>
                        <input type="hidden" name="features" id="featuresArray">

                        <div id="features-container">

                        </div>
                    @else
                        <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" class="form-control"
                            id="{{ $field['name'] }}" placeholder="{{ $field['placeholder'] }}">
                    @endif
                    @error($field['name'])
                        <span class="text-danger mt-5">{{ $message }}</span>
                    @enderror
                </div>
            @endforeach

        </div>

        <button type="submit" class="btn btn-primary">Submit</button>


    </form>
    <div class="mt-4">
        <h1>Application Products</h1>

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
                    <th>Name </th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($all_products as $key => $product)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $product['name'] }}</td>
                        <td> <img src="{{ asset($product['image']) }}" width="50" height="50" alt="Category Image">
                        </td>
                        <td>{{ $product['description'] }}</td>
                        <td>
                            <a href="/edit-application-products/{{ $product['id'] }}"
                                class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('handle.delete-application-products', $product['id']) }}" method="POST"
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
@endsection
