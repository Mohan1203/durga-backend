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
        <form method="POST" action="{{ route('handle.edit-categories', $category->id) }}" enctype="multipart/form-data">
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
                        ['name' => 'slug', 'type' => 'text', 'label' => 'Slug', 'placeholder' => 'Slug'],
                        ['name' => 'image', 'type' => 'file', 'label' => 'Category Image', 'placeholder' => ''],
                    ];
                @endphp
                @foreach ($fields as $field)
                    @if ($field['name'] == 'image')
                        <div class="col-6">
                            <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex flex-column">
                                    <input type="file" name="image" class="form-control" id="imageInput">
                                </div>
                                <div id="imageContainer" class="">
                                    @if ($category->image)
                                        <img id="previewImage" src="{{ asset(env('APP_URL') . '/' . $category->image) }}"
                                            class=" img-thumbnail">
                                    @else
                                        <img id="previewImage" src="" class="h-100 w-100 img-thumbnail d-none">
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="form-group col-6">
                            <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                            <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" class="form-control"
                                id="{{ $field['name'] }}" placeholder="{{ $field['placeholder'] }}"
                                value={{ old($field['name'], $category->{$field['name']}) }}>
                            @error($field['name'])
                                <span class="text-danger ">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                @endforeach

            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
