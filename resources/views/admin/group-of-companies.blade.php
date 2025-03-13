<!-- resources/views/admin/users.blade.php -->
@extends('layouts.admin')

@section('title', 'Users')

@section('content')
    <h1 class="text-2xl font-bold">Group of companies</h1>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form method="POST" enctype="multipart/form-data" action="{{ route('handle.add-year') }}">
        @csrf
        <div class="d-flex row">
            @php
                $fields = [
                    [
                        'name' => 'year',
                        'type' => 'number',
                        'label' => 'Year',
                        'placeholder' => 'Enter year',
                    ],
                    ['name' => 'image', 'type' => 'file', 'label' => 'Timeline Image', 'placeholder' => ''],
                    [
                        'name' => 'description',
                        'type' => 'textarea',
                        'label' => 'Description',
                        'placeholder' => 'Description',
                    ],
                ];
            @endphp
            @foreach ($fields as $field)
                <div class="form-group col-6">
                    @if ($field['type'] == 'textarea')
                        <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                        <textarea name="{{ $field['name'] }}" class="form-control" id="{{ $field['name'] }}"
                            placeholder="{{ $field['placeholder'] }}" rows="5"></textarea>
                        @error($field['name'])
                            <span class="text-danger ">{{ $message }}</span>
                        @enderror
                    @else
                        <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                        <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" class="form-control"
                            id="{{ $field['name'] }}" placeholder="{{ $field['placeholder'] }}">
                        @error($field['name'])
                            <span class="text-danger ">{{ $message }}</span>
                        @enderror
                    @endif
                </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection
