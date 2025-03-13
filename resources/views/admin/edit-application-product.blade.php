<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

{{-- @section('title', 'Dashboard') --}}

@section('content')
    <h1 class="text-2xl font-bold">Edit Application Products</h1>
    <form action="{{ route('handle.edit-application-products', $product->id) }}" method="POST" enctype="multipart/form-data">
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
                    [
                        'name' => 'description',
                        'type' => 'textarea',
                        'label' => 'Description',
                        'placeholder' => 'Description',
                    ],
                    ['name' => 'image', 'type' => 'file', 'label' => 'Product Image', 'placeholder' => ''],

                    ['name' => 'feature', 'type' => 'text', 'label' => 'Feature', 'placeholder' => 'Feature'],
                ];
            @endphp
            {{-- {{ dd($product->slug) }} --}}
            @foreach ($fields as $field)
                <div class="col-md-6 mb-3">
                    <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                    @if ($field['type'] == 'textarea')
                        <textarea name="{{ $field['name'] }}" class="form-control" id="{{ $field['name'] }}"
                            placeholder="{{ $field['placeholder'] }}" rows="5">{{ old($field['name'], $product->{$field['name']}) }}</textarea>
                    @elseif($field['type'] == 'select')
                        <select name="category_id" id="category_id" class="form-control p-3">
                            <option value="">Select Category</option>
                            @foreach ($all_categories as $category)
                                <option value="{{ $category['id'] }}"
                                    {{ old('category_id', $product->category_id) == $category['id'] ? 'selected' : '' }}>
                                    {{ $category['name'] }}</option>
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
                        <input type="hidden" name="features" id="featuresArray"
                            value="{{ json_encode($product->features) }}">
                        <div id="features-container">
                            @foreach ($product->features as $feature)
                                <div class="d-flex justify-content-between my-2 mx-1">
                                    <span class="me-2">{{ $feature }}</span>
                                    <button type="button" class="btn btn-danger btn-sm remove-feature"
                                        data-feature="{{ $feature }}">X</button>
                                </div>
                            @endforeach
                        </div>
                    @elseif($field['name'] == 'image')
                        <div class="d-flex flex-column gap-2">
                            {{-- <label for="image">Product Image</label> --}}
                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex flex-column">
                                    {{-- <i class="fa-solid fa-circle-info"></i> --}}
                                    <input type="file" name="image" class="form-control" id="imageInput">
                                </div>
                                <div id="imageContainer" class="position-relative d-inline-block">
                                    @if ($product->image)
                                        <img id="previewImage"
                                            src="{{ asset('http://localhost:8000/' . $product->image) }}"
                                            class="h-25 w-25 img-thumbnail">
                                    @else
                                        <img id="previewImage" src="" class="h-25 w-25 img-thumbnail d-none">
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" class="form-control"
                            id="{{ $field['name'] }}" placeholder="{{ $field['placeholder'] }}"
                            value={{ old($field['name'], $product->{$field['name']}) }}>
                    @endif
                    @error($field['name'])
                        <span class="text-danger mt-5">{{ $message }}</span>
                    @enderror
                </div>
            @endforeach

        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
