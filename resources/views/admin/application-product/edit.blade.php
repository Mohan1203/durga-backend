<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

{{-- @section('title', 'Dashboard') --}}

@section('content')
    <h1 class="text-2xl font-bold">Edit Application Products</h1>
    <form action="{{ route('application-products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
        class="editform" id="edit-form">
        @csrf
        @method('PUT')
        {{-- <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            Edit Application Products
                        </h4>
                        <form class="pt-3 class-create-form" id="create-form"
                            action="{{ route('application-products.update', $product->id) }}" method="POST"
                            novalidate="novalidate">
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input name="name" type="text" placeholder="Enter Product Name"
                                        class="form-control" />
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Category ID</label>
                                    <select name="category_id" id="category_id" class="form-control p-3">
                                        <option value="">{{ __('Please') }} {{ __('select') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Slug<span class="text-danger">*</span></label>
                                    <input name="slug" type="text" placeholder="Enter Slug Name"
                                        class="form-control" />
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>{{ __('files') }} </label>
                                    <input type="file" name="file[]" class="form-control" multiple />
                                </div>
                            </div>
                            <div class="row">
                                <h4>Features Sections</h4>
                                <hr>
                                <div class="form-group col-sm-12 col-md-5">
                                    <label>Title<span class="text-danger">*</span></label>
                                    <input name="feature[][name]" type="text" placeholder="Enter Product Name"
                                        class="form-control" />
                                </div>
                                <div class="form-group col-sm-12 col-md-5">
                                    <label>Description<span class="text-danger">*</span></label>
                                    <textarea name="feature[][description]" type="text" placeholder="Description" class="form-control"> </textarea>
                                </div>
                                <div class="form-group col-sm-12 col-md-2">
                                    <div class="mt-4">
                                        <button class="btn btn-primary" type="button" id="feature-add-btn">+</button>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}
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
                    [
                        'name' => 'product_description',
                        'type' => 'textarea',
                        'label' => 'Product Description',
                        'placeholder' => 'Product Description',
                    ],
                    [
                        'name' => 'product_desc_image',
                        'type' => 'file',
                        'label' => 'Product Description Image',
                        'placeholder' => '',
                    ],
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
                        <div class="form-group">
                            <select name="category_id" id="category_id" class="form-control p-3">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category['id'] }}" data-name="{{ $category['name'] }}">
                                        {{ $category['name'] }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categories')
                                <span class="text-danger mt-5">{{ $message }}</span>
                            @enderror
                            <input type="hidden" name="categories" id="categories"
                                value="{{ json_encode($selectedCategories) }}">
                            <input type="hidden" id="categoriesWithNames"
                                value="{{ json_encode($selectedCategoriesWithNames ?? []) }}">
                            <div id="categories-container" class="mt-2 d-flex flex-wrap gap-2"></div>
                        </div>
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

                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex flex-column">
                                    <input type="file" name="image" class="form-control" id="imageInput">
                                </div>
                                <div id="imageContainer" class="position-relative d-inline-block">
                                    @if ($product->image)
                                        <img id="previewImage" src="{{ asset(env('APP_URL') . '/' . $product->image) }}"
                                            class="h-25 w-25 img-thumbnail">
                                    @else
                                        <img id="previewImage" src="" class="h-25 w-25 img-thumbnail d-none">
                                    @endif
                                </div>
                            </div>
                        </div>
                    @elseif($field['name'] == 'product_desc_image')
                        <div class="d-flex flex-column gap-2">

                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex flex-column">
                                    <input type="file" name="product_desc_image" class="form-control" id="imageInput">
                                </div>
                                <div id="imageContainer" class="position-relative d-inline-block">
                                    @if ($product->product_desc_image)
                                        <img id="previewImage"
                                            src="{{ asset(env('APP_URL') . '/' . $product->product_desc_image) }}"
                                            class="h-25 w-25 img-thumbnail">
                                    @else
                                        <img id="previewImage" src="" class="h-25 w-25 img-thumbnail d-none">
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- {{ dd($product->{$field['name']}) }} --}}
                        <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" class="form-control"
                            id="{{ $field['name'] }}" placeholder="{{ $field['placeholder'] }}"
                            value="{{ old($field['name'], $product->{$field['name']}) }}">
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
