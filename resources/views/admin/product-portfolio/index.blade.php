@extends('layouts.admin')
@section('content')
    <div class="">
        <div class="page-header">
            <h3 class="page-title">
                Manage Products
            </h3>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            Create Products
                        </h4>
                        <form class="pt-3 class-create-form" id="create-form" action="{{ route('product-portfolio.store') }}"
                            method="POST" novalidate="novalidate">
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input name="name" type="text" placeholder="Enter Product Name"
                                        class="form-control" />
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Category</label>
                                    <select name="category_id" id="category_id" class="form-control p-3">
                                        <option value="">{{ __('Please') }} {{ __('select') }}</option>
                                        @foreach ($Categories as $category)
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
                                    <label>Images</label>
                                    <input type="file" name="file[]" class="form-control" multiple />
                                </div>
                            </div>
                            <h4>Features Sections</h4>
                            <hr>
                            <div class="row feature-row">
                                <div class="form-group col-sm-12 col-md-5">
                                    <label>Title<span class="text-danger">*</span></label>
                                    <input name="feature[0][name]" type="text" placeholder="Product Title"
                                        class="form-control" />
                                </div>
                                <div class="form-group col-sm-12 col-md-5">
                                    <label>Description<span class="text-danger">*</span></label>
                                    <textarea name="feature[0][description]" type="text" class="form-control"></textarea>
                                </div>
                                <div class="form-group col-sm-12 col-md-2">
                                    <div class="mt-4">
                                        <button class="btn btn-primary add-feature" type="button">+</button>
                                    </div>
                                </div>
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
                            List Products
                        </h4>

                        <table aria-describedby="mydesc" class='table' id='table_list' data-toggle="table"
                            data-url="{{ route('product-portfolio.show', 1) }}" data-click-to-select="true"
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
                                    <th scope="col" data-visible="false" data-field="category_id" data-sortable="true">
                                        Category ID</th>
                                    <th scope="col" data-field="category_name" data-sortable="true">Category</th>
                                    <th scope="col" data-field="slug" data-sortable="true">Slug</th>
                                    <th scope="col" data-field="created_at" data-sortable="true" data-visible="false">
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
    @endsection
    @section('script')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("add-feature").addEventListener("click", function() {
                    let featureSection = document.querySelector(".row"); // Select the feature section
                    let clonedSection = featureSection.cloneNode(true); // Clone the feature section

                    // Clear input values
                    clonedSection.querySelectorAll("input, textarea").forEach(input => input.value = "");

                    // Append cloned section after the last feature section
                    featureSection.parentNode.appendChild(clonedSection);
                });
            });
        </script>
    @endsection
