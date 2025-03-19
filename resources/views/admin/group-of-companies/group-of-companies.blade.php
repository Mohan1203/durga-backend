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
        </div>
        </form>
    </div>

    <div class="col-md-12 grid-margin stretch-card mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    List Products
                </h4>
                <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table"
                    data-url="{{ route('handle.show-grp-comp', 1) }}" data-click-to-select="true"
                    data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]"
                    data-search="true" data-show-columns="true" data-show-refresh="true" data-trim-on-search="false"
                    data-mobile-responsive="true" data-sort-name="id" data-toolbar="#toolbar" data-sort-order="desc"
                    data-maintain-selected="true" data-export-types='["txt","excel"]'
                    data-export-options='{ "fileName": "class-list-<?= date('d-m-y') ?>" ,"ignoreColumn":
                    ["operate"]}' data-show-export="true">
                    <thead>
                        <tr>
                            <th scope="col" data-field="id" data-sortable="true" data-visible="false">ID</th>
                            <th scope="col" data-field="no" data-sortable="false">No</th>
                            <th scope="col" data-field="year" data-sortable="true">Year</th>
                            {{-- <th scope="col" data-visible="false" data-field="category_id" data-sortable="true">
                                Category ID</th> --}}
                            <th scope="col" data-field="image">Image</th>
                            <th scope="col" data-field="description">Description</th>
                            <th scope="col" data-field="created_at" data-sortable="true" data-visible="false">
                                Created At</th>
                            <th scope="col" data-field="updated_at" data-sortable="true" data-visible="false">Deleted At
                            </th>
                            <th scope="col" data-field="operate" data-sortable="false">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    </div>
@endsection
