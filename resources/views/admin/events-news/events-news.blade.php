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
                            Create Application Products
                        </h4>

                        <form class="pt-3 class-create-form" id="create-form" action="{{ route('events-and-news.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input name="name" type="text" placeholder="Enter Product Name"
                                        class="form-control" />
                                    @error('name')
                                        <span class="text-danger mt-5">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Image <span class="text-danger">*</span></label>
                                    <input name="image" type="file" placeholder="" class="form-control" />
                                    @error('image')
                                        <span class="text-danger mt-5">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class=" col-md-12 grid-margin stretch-card ">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            List Of events
                        </h4>

                        <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table"
                            data-url="{{ route('events-and-news.show', 1) }}" data-click-to-select="true"
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
                                    <th scope="col" data-field="name" data-sortable="true">Name</th>
                                    <th scope="col" data-field="image" data-sortable="true">Image</th>
                                    <th scope="col" data-field="operate" data-sortable="false">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    @endsection
