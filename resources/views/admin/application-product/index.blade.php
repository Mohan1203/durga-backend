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
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="text-danger mt-5">{{ $message }}</span>
                                    @enderror
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
                                    <label>Images</label>
                                    <input type="file" name="image" id="image" class="form-control" />
                                    @error('image')
                                        <span class="text-danger mt-5">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- <div> --}}
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Description<span class="text-danger">*</span></label>
                                    <textarea name="description" type="text" class="form-control"></textarea>
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
                                    <th scope="col" data-visible="false" data-field="category_id"
                                        data-sortable="true">
                                        Category ID</th>
                                    <th scope="col" data-field="category_name" data-sortable="true">Category</th>
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
    @endsection
    @section('script')
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Function to refresh CSRF token
            function refreshToken() {
                $.get('{{ route('refresh-csrf') }}').done(function(data) {
                    $('meta[name="csrf-token"]').attr('content', data);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': data
                        }
                    });
                });
            }

            document.addEventListener("DOMContentLoaded", function() {
                // Feature functionality
                const featureInput = document.getElementById("feature");
                const featureAddBtn = document.getElementById("feature-add-btn");
                const featuresContainer = document.getElementById("features-container");
                const featuresArrayInput = document.getElementById("featuresArray");

                let features = [];

                // Load existing features if editing
                if (featuresArrayInput.value) {
                    try {
                        features = JSON.parse(featuresArrayInput.value);
                        renderFeatures();
                    } catch (e) {
                        console.error("Error parsing features:", e);
                    }
                }

                featureAddBtn.addEventListener("click", function() {
                    const featureValue = featureInput.value.trim();
                    if (featureValue) {
                        features.push(featureValue);
                        featuresArrayInput.value = JSON.stringify(features);
                        featureInput.value = "";
                        renderFeatures();
                    }
                });

                function renderFeatures() {
                    featuresContainer.innerHTML = "";
                    features.forEach((feature, index) => {
                        const featureItem = document.createElement("div");
                        featureItem.className =
                            "d-flex justify-content-between align-items-center mt-2 border p-2 rounded";
                        featureItem.innerHTML = `
                            <span>${feature}</span>
                            <button type="button" class="btn btn-sm btn-danger remove-feature" data-index="${index}">
                                <i class="fa fa-times"></i>
                            </button>
                        `;
                        featuresContainer.appendChild(featureItem);
                    });

                    // Add event listeners to remove buttons
                    document.querySelectorAll(".remove-feature").forEach(button => {
                        button.addEventListener("click", function() {
                            const index = parseInt(this.dataset.index);
                            features.splice(index, 1);
                            featuresArrayInput.value = JSON.stringify(features);
                            renderFeatures();
                        });
                    });
                }

                // Handle delete functionality with CSRF token refresh
                $(document).on('click', '.delete-form', function(e) {
                    e.preventDefault();
                    var productId = $(this).data('id');
                    var deleteUrl = $(this).data('url');

                    if (confirm('Are you sure you want to delete this product?')) {
                        $.ajax({
                            url: deleteUrl,
                            type: 'DELETE',
                            data: {
                                "_token": $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                showSuccessMessage('Product deleted successfully');
                                // Reload the table after successful deletion
                                $('#table_list').bootstrapTable('refresh');
                            },
                            error: function(xhr) {
                                console.log(xhr);
                                if (xhr.status === 419) { // CSRF token mismatch
                                    refreshToken();
                                    alert('Your session has expired. Please try again.');
                                } else {
                                    alert('Error deleting product: ' + xhr.responseJSON?.message ||
                                        'Unknown error');
                                }
                            }
                        });
                    }
                });

                // Show success/error messages
                function showSuccessMessage(message) {
                    $('<div class="alert alert-success">' + message + '</div>')
                        .appendTo('.page-header')
                        .delay(3000)
                        .fadeOut(350, function() {
                            $(this).remove();
                        });
                }

                // Auto hide alerts
                $('.alert-success, .alert-danger').delay(3000).fadeOut(350);
            });
        </script>
    @endsection
