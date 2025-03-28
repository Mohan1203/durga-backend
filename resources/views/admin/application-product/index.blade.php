@extends('layouts.admin')
@section('content')
    <div class="">
        <div class="page-header">
            <h3 class="page-title">
                Manage Application Products
            </h3>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            Create Application Products
                        </h4>
                        <form class="pt-3 class-create-form" id="create-form"
                            action="{{ route('application-products.store') }}" method="POST" novalidate="novalidate"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                {{-- {{ dd($message) }} --}}
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input name="name" type="text" placeholder="Enter Product Name"
                                        class="form-control" />
                                    @error('name')
                                        <span class="text-danger mt-5">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Category</label>
                                    <select name="category_id" id="category_id" class="form-control p-3">
                                        <option value="">{{ __('Please') }} {{ __('select') }}</option>
                                        @foreach ($Categories as $category)
                                            <option value="{{ $category->id }}" data-name="{{ $category->name }}">
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('categories')
                                        <span class="text-danger mt-5">{{ $message }}</span>
                                    @enderror
                                    <input type="hidden" name="categories" id="categories">
                                    <div id="categories-container" class="mt-2 d-flex flex-wrap gap-2"></div>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Slug<span class="text-danger">*</span></label>
                                    <input name="slug" type="text" placeholder="Enter Slug Name"
                                        class="form-control" />
                                    @error('slug')
                                        <span class="text-danger mt-5">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Description<span class="text-danger">*</span></label>
                                    <textarea name="description" type="text" class="form-control"></textarea>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Images</label>
                                    <input type="file" name="image" id="image" class="form-control" />
                                    @error('image')
                                        <span class="text-danger mt-5">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Product Description</label>
                                    <textarea name="product_description" type="text" class="form-control"></textarea>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Description Image</label>
                                    <input type="file" name="product_desc_image" id="product_desc_image"
                                        class="form-control" />
                                </div>
                                <div class="form-group col-sm-12 col-md-6 ">
                                    {{-- <div class="row "> --}}
                                    <label>Features<span class="text-danger">*</span></label>
                                    <div class=" d-flex justify-content-between align-items-center gap-4">
                                        <div class="w-100">
                                            <input name="feature" type="text" placeholder="Product Title"
                                                class="form-control " id="feature" />
                                        </div>
                                        <div class="">
                                            <button class="btn btn-primary" type="button" id="feature-add-btn">Add</button>
                                        </div>
                                        <input type="hidden" name="features" id="featuresArray">
                                    </div>

                                    <div id="features-container" class="mt-2">
                                    </div>
                                    {{-- </div> --}}
                                </div>

                                {{-- </div> --}}
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>

                        </form>
                    </div>
                </div>
            </div>


            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            List Application Products
                        </h4>
                        <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table"
                            data-url="{{ route('application-products.show', 1) }}" data-click-to-select="true"
                            data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]"
                            data-search="true" data-show-columns="true" data-show-refresh="true"
                            data-trim-on-search="false" data-mobile-responsive="true" data-sort-name="id"
                            data-toolbar="#toolbar" data-sort-order="desc" data-maintain-selected="true"
                            data-export-types='["txt","excel"]'
                            data-export-options='{ "fileName": "class-list-<?= date('d-m-y') ?>" ,"ignoreColumn":
                            ["operate"]}' data-show-export="true">
                            <thead>
                                <tr>
                                    <th scope="col" data-field="id" data-sortable="true">ID</th>
                                    {{-- <th scope="col" data-field="drag" data-sortable="true" data-visible="false">Drag
                                    </th> --}}
                                    <th scope="col" data-field="no" data-sortable="false">No</th>
                                    <th scope="col" data-field="name" data-sortable="true">Name</th>
                                    <th scope="col" data-field="category_id" data-sortable="true"
                                        data-visible="false">Category ID</th>
                                    <th scope="col" data-field="category_name" data-sortable="true">Primary Category
                                    </th>

                                    <th scope="col" data-field="slug" data-sortable="true">Slug</th>
                                    <th scope="col" data-field="created_at" data-sortable="true"
                                        data-visible="false">
                                        Created At</th>
                                    <th scope="col" data-field="updated_at" data-sortable="true"
                                        data-visible="false">Deleted At</th>
                                    <th scope="col" data-field="operate" data-sortable="false">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
