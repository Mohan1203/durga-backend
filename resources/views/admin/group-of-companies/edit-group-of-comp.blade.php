<!-- resources/views/admin/users.blade.php -->
@extends('layouts.admin')

@section('title', 'Users')

@section('content')
    <div>
        <div class="stretch-card row">
            <div class="page-header">
                <h3 class="page-title">
                    Group of companies
                </h3>
            </div>
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="row">


                <form method="POST" enctype="multipart/form-data" action="{{ route('handle.edit-grp-cmp', $timeline->id) }}">
                    @csrf
                    <div class=" row">
                        @php
                            $fields = [
                                [
                                    'name' => 'year',
                                    'type' => 'number',
                                    'label' => 'Year',
                                    'placeholder' => 'Enter year',
                                ],
                                [
                                    'name' => 'description',
                                    'type' => 'textarea',
                                    'label' => 'Description',
                                    'placeholder' => 'Description',
                                ],

                                ['name' => 'image', 'type' => 'file', 'label' => 'Timeline Image', 'placeholder' => ''],
                            ];
                        @endphp
                        @foreach ($fields as $field)
                            <div class="form-group col-6">
                                @if ($field['type'] == 'textarea')
                                    <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                                    <textarea name="{{ $field['name'] }}" class="form-control" id="{{ $field['name'] }}"
                                        placeholder="{{ $field['placeholder'] }}" rows="5">{{ old($field['name'], $timeline->{$field['name']}) }}</textarea>
                                    @error($field['name'])
                                        <span class="text-danger ">{{ $message }}</span>
                                    @enderror
                                @elseif ($field['name'] == 'image')
                                    <div class="">
                                        <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                                        <div class="d-flex flex-column gap-2">
                                            <div class="d-flex flex-column">
                                                <input type="file" name="image" class="form-control" id="imageInput">
                                            </div>
                                            <div id="imageContainer" class="">
                                                @if ($timeline->image)
                                                    <img id="previewImage"
                                                        src="{{ asset(env('APP_URL') . '/' . $timeline->image) }}"
                                                        class=" img-thumbnail">
                                                @else
                                                    <img id="previewImage" src=""
                                                        class="h-100 w-100 img-thumbnail d-none">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                                    <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" class="form-control"
                                        id="{{ $field['name'] }}" placeholder="{{ $field['placeholder'] }}"
                                        value={{ old($field['name'], $timeline->{$field['name']}) }}>
                                    @error($field['name'])
                                        <span class="text-danger ">{{ $message }}</span>
                                    @enderror
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
        </form>
    </div>


    </div>
@endsection
