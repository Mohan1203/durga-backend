@extends('layouts.admin')

{{-- @section('content')
    <h1 class="text-2xl font-bold">Application Products</h1>
    <form method="POST" enctype="multipart/form-data" action="{{ route('handle.add-application-products') }}">
        @csrf
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
                    ['name' => 'image', 'type' => 'file', 'label' => 'Product Image', 'placeholder' => ''],
                    [
                        'name' => 'description',
                        'type' => 'textarea',
                        'label' => 'Description',
                        'placeholder' => 'Description',
                    ],

                    ['name' => 'feature', 'type' => 'text', 'label' => 'Feature', 'placeholder' => 'Feature'],
                ];
            @endphp

            @foreach ($fields as $field)
                <div class="col-md-6 mb-3">
                    <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                    @if ($field['type'] == 'textarea')
                        <textarea name="{{ $field['name'] }}" class="form-control" id="{{ $field['name'] }}"
                            placeholder="{{ $field['placeholder'] }}" rows="5"></textarea>
                    @elseif($field['type'] == 'select')
                        <select name="category_id" id="category_id" class="form-control p-3">
                            <option value="">Select Category</option>
                            @foreach ($all_categories as $category)
                                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                            @endforeach
                        </select>
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
                        <input type="hidden" name="features" id="featuresArray">

                        <div id="features-container">

                        </div>
                    @else
                        <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" class="form-control"
                            id="{{ $field['name'] }}" placeholder="{{ $field['placeholder'] }}">
                    @endif
                    @error($field['name'])
                        <span class="text-danger mt-5">{{ $message }}</span>
                    @enderror
                </div>
            @endforeach

        </div>

        <button type="submit" class="btn btn-primary">Submit</button>


    </form>
    <div class="mt-4">
        <h1>Application Products</h1>

        <!-- Loading Spinner -->
        <div id="loading-spinner" class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <table id="categories-table" class="table table-bordered d-none">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name </th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($all_products as $key => $product)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $product['name'] }}</td>
                        <td> <img src="{{ asset($product['image']) }}" width="50" height="50" alt="Category Image">
                        </td>
                        <td>{{ $product['description'] }}</td>
                        <td>
                            <a href="/edit-application-products/{{ $product['id'] }}"
                                class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('handle.delete-application-products', $product['id']) }}" method="POST"
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
@endsection --}}
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <strong>Manage Products </strong>
            </h3>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            Create Products
                        </h4>
                        <form class="pt-3 class-create-form" id="create-form" action=""
                            method="POST" novalidate="novalidate">
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input name="name" type="text" placeholder="Enter Product Name" class="form-control" />
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Category ID</label>
                                    <select name="category_id" id="category_id" class="form-control p-3">
                                        <option value="">{{__('Please')}}  {{__('select')}}</option>
                                        @foreach ($Categories as $category)
                                            <option value="{{ $category->id}}">{{ $category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Slug<span class="text-danger">*</span></label>
                                    <input name="slug" type="text" placeholder="Enter Slug Name" class="form-control" />
                                </div>
                            </div>
                            <div class="row">
                                <h4>Features Sections</h4>
                                <hr>
                                <div class="form-group col-sm-12 col-md-5">
                                    <label>Title<span class="text-danger">*</span></label>
                                    <input name="feature[][name]" type="text" placeholder="Enter Product Name" class="form-control" />
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

                            {{-- <div class="row"> --}}
                                <button type="submit" class="btn btn-primary">Submit</button>
                            {{-- </div> --}}
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
                        data-url="{{ url('product-list') }}" data-click-to-select="true" data-side-pagination="server"
                        data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true"
                        data-show-columns="true" data-show-refresh="true" data-trim-on-search="false"
                        data-mobile-responsive="true" data-sort-name="id" data-toolbar="#toolbar" data-sort-order="desc"
                        data-maintain-selected="true" data-export-types='["txt","excel"]'
                        data-export-options='{ "fileName": "class-list-<?= date('d-m-y') ?>" ,"ignoreColumn":
                        ["operate"]}' data-show-export="true">
                        <thead>
                            <tr>
                                <th scope="col" data-field="id" data-sortable="true" data-visible="false">
                                    {{ __('id') }}</th>
                                <th scope="col" data-field="no" data-sortable="false">No</th>
                                <th scope="col" data-field="name" data-sortable="true">Name</th>
                                <th scope="col" data-visible="false" data-field="category_id" data-sortable="true">Category ID</th>
                                <th scope="col" data-field="category_name" data-sortable="true">Category Name</th>
                                <th scope="col" data-field="slug" data-sortable="true">Slug</th>       
                                <th scope="col" data-field="created_at" data-sortable="true" data-visible="false">
                                    {{ __('created_at') }}</th>
                                <th scope="col" data-field="updated_at" data-sortable="true" data-visible="false">
                                    {{ __('updated_at') }}</th>
                                <th scope="col" data-field="operate" data-sortable="false"
                                    data-events="classEvents">{{ __('action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>


            <!-- Modal -->
            {{-- <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ __('edit') . ' ' . __('class') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form class="class-edit-form" id="edit-form" action="{{ url('class') }}"
                            novalidate="novalidate">
                            <div class="modal-body">
                                <input type="hidden" name="edit_id" id="edit_id" value="" />
                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-12">
                                        <label>{{ __('name') }} <span class="text-danger">*</span></label>
                                        <input name="name" id="edit_name" type="text" placeholder="{{ __('name') }}" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('educational_program') }} <span class="text-info">(optional)</span></label>
                                    <select name="educational_program" id="edit_educational_program_id" class="form-control select2" style="width:100%;" tabindex="-1" aria-hidden="true">
                                        <option value="">{{__('Please')}}  {{__('select')}}</option>
                                        @foreach($educational_programs as $program)
                                            <option value="{{$program->id}}">{{$program->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-12">
                                        <label>{{ __('shifts') }} <span class="text-info">(optional)</span></label>
                                        <select name="shift_id" id="edit_shift_id" class="form-control select2" style="width:100%;" tabindex="-1" aria-hidden="true">
                                            <option value="">{{__('Please')}}  {{__('select')}}</option>
                                            @foreach($shifts as $shift)
                                                <option value="{{$shift->id}}">{{$shift->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-12">
                                        <label>{{ __('medium') }} <span class="text-danger">*</span></label>
                                        <select name="medium_id" id="edit_medium_id" class="form-control select2" style="width:100%;" tabindex="-1" aria-hidden="true">
                                            <option value="">{{__('Please')}}  {{__('select')}}</option>
                                            @foreach ($mediums as $medium)
                                                <option value="{{ $medium->id }}">{{ $medium->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-12">
                                        <label>{{ __('stream') }}<span class="text-info">(optional)</span></label>
                                        <select name="stream_id" id="edit_stream_id" class="form-control select2" style="width:100%;" tabindex="-1" aria-hidden="true">
                                            <option value="">{{__('Please')}}  {{__('select')}}</option>
                                            @foreach($streams as $stream)
                                                <option value="{{$stream->id}}">{{$stream->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-12">
                                        <label>{{ __('section') }} <span class="text-danger">*</span></label>
                                        <select multiple name="section_id[]" id="edit_section_id" class="form-control js-example-basic-single select2-hidden-accessible">
                                            @foreach ($sections as $section)
                                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-12 col-md-12">
                                        @if (count($semesters) > 0)
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" id="edit_include_semesters" name="include_semesters" value="1">{{ __('Include Semesters') }}
                                                </label>
                                            </div>
                                        @endif
                                        <br>
                                        <small class="text-danger">* {{__("By Changing this Semester setting, your existing data related to this class will be Auto Deleted")}}</small>
                                        <ol class="text-danger">
                                            <li>{{__("Class Subject")}}</li>
                                            <li>{{__("timetable")}}</li>
                                            <li>{{__("Lesson & Topic")}}</li>
                                            <li>{{__("Exam & Marks")}}</li>
                                            <li>{{__("announcement")}}</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{ __('close') }}</button>
                                <input class="btn btn-theme" type="submit" value={{ __('edit') }} />
                            </div>
                        </form>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
