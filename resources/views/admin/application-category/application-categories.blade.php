@extends('layouts.admin')

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
                        <th>Drag</th>
                        <th>#</th>
                        <th>Category Name</th>
                        <th>Slug</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="sortable-categories">

                    @foreach ($all_categories as $key => $category)
                        <tr data-id="{{ $category['id'] }}">
                            <td class="drag-handle" data-id="{{ $category['id'] }}">{{ $category['id'] }}</td>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $category['name'] }}</td>
                            <td>{{ $category['slug'] }}</td>
                            <td>
                                <img src="{{ asset(env('APP_URL') . '/' . $category['image']) }}" width="50"
                                    height="50" alt="Category Image">
                            </td>
                            <td>
                                <a href="/edit_category/{{ $category['id'] }}" class="btn btn-warning btn-sm">Edit</a>

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

    <!-- jQuery & jQuery UI -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#sortable-categories").sortable({
                update: function(event, ui) {
                    let orderedIds = [];
                    $(".drag-handle").each(function() {
                        orderedIds.push($(this).data("id"));
                    });

                    const orderedId = JSON.stringify(orderedIds);
                    $.ajax({
                        url: "{{ route('handle.update-category-sequence') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            orderedIds: orderedIds
                        },
                        success: function(response) {
                            console.log("Order updated successfully");
                        },
                        error: function(xhr) {
                            console.log("Error updating order:", xhr.responseText);
                        }
                    });
                }
            }).disableSelection();
        });
    </script>
@endsection
