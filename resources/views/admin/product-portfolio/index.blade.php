@extends('layouts.admin')
@section('content')
    <div class="">
        <div class="page-header">
            <h3 class="page-title">
                Manage Products Portfolio
            </h3>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            Create Products Portfolio
                        </h4>
                        <form class="pt-3 class-create-form" id="create-form" action="{{ route('product-portfolio.store') }}"
                            method="POST" novalidate="novalidate" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Heading</label>
                                    <input name="heading" type="text" placeholder="Enter Title Name" class="form-control" />
                                </div>
                                <div class="form-group col-sm-12 col-md-5">
                                    <label>Sub Heading</label>
                                    <textarea name="subheading" type="text" class="form-control"></textarea>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Name</label>
                                    <input name="name" type="text" placeholder="Enter Product Name"
                                        class="form-control" />
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Description</label>
                                    <textarea name="description" type="text" class="form-control"></textarea>
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Slug<span class="text-danger">*</span></label>
                                    <input name="slug" type="text" placeholder="Enter Slug Name"
                                        class="form-control" />
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Images</label>
                                    <input type="file" name="image"  accept="image/*" class="form-control" />
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
                            <div class="mt-3 extra-features"></div>
                            <h4>Our Grades Section</h4>
                            <hr>
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Title</label>
                                    <input name="grade_title" type="text" placeholder="Enter Title Name" class="form-control" />
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Description</label>
                                    <textarea name="grade_description" type="text" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="row category-row">
                                <div class="form-group col-sm-12 col-md-5">
                                    <label>Parent Category</label>
                                    <input name="category[0][parent]" type="text" placeholder="Enter Title Name" class="form-control" />
                                </div>
                                <div class="form-group col-sm-12 col-md-5">
                                    <label>Child Category</label>
                                    <input name="category[0][child]" id="tags" class="form-control" value=""/>
                                </div>
                                <div class="form-group col-sm-12 col-md-2">
                                    <div class="mt-4">
                                        <button class="btn btn-primary add-category" type="button">+</button>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 extra-category"></div>
                            
                            <h4>Key Features Section</h4>
                            <hr>
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Heading</label>
                                    <input name="feature_title" type="text" placeholder="Enter Title Name" class="form-control" />
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>SubHeading</label>
                                    <textarea name="feature_description" type="text" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="row key-feature-row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Title</label>                                    
                                    <input name="key_feature[0][name]" type="text" placeholder="Enter Title Name" class="form-control" />
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Description</label>
                                    <textarea name="key_feature[0][description]" type="text" class="form-control"></textarea>
                                </div> 
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Images</label>
                                    <input type="file" name="key_feature[0][image]" class="form-control" multiple />
                                </div>                               
                                <div class="form-group col-sm-12 col-md-2">
                                    <div class="mt-4">
                                        <button class="btn btn-primary add-key-feature" type="button">+</button>
                                    </div>
                                </div>      
                            </div>
                            
                            <div class="mt-3 extra-key-feature"></div>


                            <h4>Industry Information Section</h4>
                            <hr>
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Title</label>
                                    <input name="industry_title" type="text" placeholder="Enter Title Name" class="form-control" />
                                </div>
                            </div>
                            <div class="row industry-row">
                                <div class="form-group col-sm-12 col-md-5">
                                    <label>Name</label>                                    
                                    <input name="industry[0][name]" type="text" placeholder="Enter Title Name" class="form-control" />
                                </div>
                                <div class="form-group col-sm-12 col-md-5">
                                    <label>Images</label>
                                    <input type="file" name="industry[0][image]" class="form-control" multiple />
                                </div>                               
                                <div class="form-group col-sm-12 col-md-2">
                                    <div class="mt-4">
                                        <button class="btn btn-primary add-industry" type="button">+</button>
                                    </div>
                                </div>      
                            </div>
                            <div class="mt-3 extra-industry"></div>

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
                        data-url="{{ route('product-portfolio.show', 1) }}" data-click-to-select="true" data-side-pagination="server"
                        data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]" data-search="true"
                        data-show-columns="true" data-show-refresh="true" data-trim-on-search="false"
                        data-mobile-responsive="true" data-sort-name="id" data-toolbar="#toolbar" data-sort-order="desc"
                        data-maintain-selected="true" data-export-types='["txt","excel"]'
                        data-export-options='{ "fileName": "class-list-<?= date('d-m-y') ?>" ,"ignoreColumn":
                        ["operate"]}' data-show-export="true">
                        <thead>
                            <tr>
                                <th scope="col" data-field="id" data-sortable="true" data-visible="false">ID</th>
                                <th scope="col" data-field="no" data-sortable="false">No</th>
                                <th scope="col" data-field="heading" data-sortable="true">Heading</th>
                                <th scope="col" data-field="sub_heading" data-sortable="true">Sub Heading</th>
                                <th scope="col" data-field="name" data-sortable="true">Name</th>
                                <th scope="col" data-field="slug" data-sortable="true">Slug</th>
                                <th scope="col" data-field="description" data-sortable="true">Description</th>  
                                <th scope="col" data-field="image" data-formatter="imageFormatter" data-sortable="true">Image</th> 
                                <th scope="col" data-field="created_at" data-sortable="true" data-visible="false">Created At</th>
                                <th scope="col" data-field="updated_at" data-sortable="true" data-visible="false">Deleted At</th>
                                <th scope="col" data-field="operate" data-sortable="false" >Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
