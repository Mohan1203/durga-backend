<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
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
                        Edit Products Portfolio
                    </h4>
                    <form class="pt-3 class-create-form" id="create-form" action="{{ route('product-portfolio.update', $product->id) }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-6"> 
                                <label>Heading</label>
                                <input name="heading" value="{{ $product->heading }}" type="text" placeholder="Enter Title Name" class="form-control" />
                            </div>
                            <div class="form-group col-sm-12 col-md-5">
                                <label>Sub Heading</label>
                                <textarea name="subheading" type="text" class="form-control">{{ $product->sub_heading }}</textarea>
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label>Name</label>
                                <input name="name" type="text" placeholder="Enter Product Name" class="form-control" value="{{ $product->name }}" />
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label>Description</label>
                                <textarea name="description" type="text" class="form-control">{{ $product->description }}</textarea>
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label>Slug<span class="text-danger">*</span></label>
                                <input name="slug" type="text" placeholder="Enter Slug Name" class="form-control" value="{{ $product->slug }}" />
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label>Images</label>
                                <input type="file" name="image"  accept="image/*" class="form-control" />
                                <input type="hidden" name="image" value="{{ $product->image }}" />
                                @if($product->image != null)
                                    <img src="{{ $product->image }}" alt="image" class="img-thumbnail" style="width: 100px; height: 100px;">                                    
                                @endif
                            </div>
                        </div>
                        <h4>Features Sections</h4>
                        <hr>
                        @foreach ($product->featureSection as $index => $feature)
                            <div class="row feature-row">
                                <input type="hidden" name="feature[{{ $index }}][id]" value="{{ $feature['id'] }}"/>
                                <div class="form-group col-sm-12 col-md-5">
                                    <label>Title<span class="text-danger">*</span></label>
                                    <input name="feature[{{ $index }}][name]" type="text" placeholder="Product Title" 
                                        class="form-control" value="{{ $feature['title'] }}" />
                                </div>
                                <div class="form-group col-sm-12 col-md-5">
                                    <label>Description<span class="text-danger">*</span></label>
                                    <textarea name="feature[{{ $index }}][description]" class="form-control">{{ $feature['description'] }}</textarea>
                                </div>
                                <div class="form-group col-sm-12 col-md-2">
                                    <div class="mt-4">
                                        @if ($index == 0)
                                            <button class="btn btn-primary add-feature" type="button">+</button>
                                        @else
                                            <button class="btn btn-danger remove-feature" data-url="{{ url('delete-feature', $feature['id']) }}"  data-id="{{ $feature['id'] }}" type="button">-</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    
                        <div class="mt-3 extra-features"></div>
                        <h4>Our Grades Section</h4>
                        <hr>
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-6">
                                <label>Title</label>
                                <input name="grade_title" type="text" placeholder="Enter Title Name" class="form-control" value="{{ $product->grade_title }}" />
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label>Description</label>
                                <textarea name="grade_description" type="text" class="form-control">{{ $product->grade_description }}</textarea>
                            </div>
                        </div>
                        @foreach ($product->grade as $index => $grade)
                            <div class="row category-row">
                                <input type="hidden" name="grade[{{ $index }}][id]" value="{{ $grade['id'] }}"/>
                                <div class="form-group col-sm-12 col-md-5">
                                    <label>Parent Category</label>
                                    <input name="grade[{{ $index }}][parent_category]" type="text" placeholder="Enter Title Name" class="form-control" value="{{ $grade['parent_category'] }}" />
                                </div>
                                <div class="form-group col-sm-12 col-md-5">
                                    <label>Child Category</label>
                                    <input name="grade[{{ $index }}][child_category]" id="tags" class="form-control" value="{{ $grade['child_category'] }}"/>
                                </div>
                                <div class="form-group col-sm-12 col-md-2">
                                    <div class="mt-4">
                                        @if ($index == 0)
                                            <button class="btn btn-primary add-grade" type="button">+</button>
                                        @else
                                            <button class="btn btn-danger remove-grade" data-url="{{ url('delete-grade', $grade['id']) }}" data-id="{{ $grade['id'] }}" type="button">-</button>
                                        @endif
                                    </div>                                    
                                </div>                                
                            </div>
                        @endforeach
                        <div class="mt-3 extra-category"></div>
                        
                        <h4>Key Features Section</h4>
                        <hr>
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-6">
                                <label>Heading</label>
                                <input name="feature_title" type="text" placeholder="Enter Title Name" class="form-control" value="{{ $product->key_feature_title }}" />
                            </div>
                            <div class="form-group col-sm-12 col-md-6">
                                <label>SubHeading</label>
                                <textarea name="feature_description" type="text" class="form-control">{{ $product->key_feature_description }}</textarea>
                            </div>
                        </div>

                        @foreach ($product->keyFeature as $index => $keyFeature)
                            {{-- @dd($keyFeature) --}}
                            <div class="row key-feature-row">
                                <input type="hidden" name="key_feature[{{ $index }}][id]" value="{{ $keyFeature['id'] }}"/>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Title</label>                                    
                                    <input name="key_feature[{{ $index }}][name]" type="text" placeholder="Enter Title Name" class="form-control" value="{{ $keyFeature['name'] }}" />
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Description</label>
                                    <textarea name="key_feature[{{ $index }}][description]" type="text" class="form-control">{{ $keyFeature['description'] }}</textarea>
                                </div> 
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Images</label>
                                    <input type="file" name="key_feature[{{ $index }}][image]" class="form-control"/>
                                    @if($keyFeature['image'] !== null)
                                        <img src="{{ $keyFeature['image'] }}" alt="image" class="img-thumbnail" style="width: 100px; height: 100px;">
                                    @endif
                                </div>                               
                                <div class="form-group col-sm-12 col-md-2">
                                    <div class="mt-4">
                                        @if ($index == 0)
                                            <button class="btn btn-primary add-key-feature" type="button">+</button>
                                        @else
                                        <button class="btn btn-danger remove-key-feature" data-url="{{ url('delete-feature', $keyFeature['id']) }}" data-id="{{ $keyFeature['id'] }}">-</button>
                                    
                                        @endif
                                    </div>                                    
                                </div>  
                            </div>
                        @endforeach
                        <div class="mt-3 extra-key-feature"></div>

                        <h4>Industry Information Section</h4>
                        <hr>
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-6">
                                <label>Title</label>
                                <input name="industry_title" type="text" placeholder="Enter Title Name" class="form-control" value="{{ $product->indutry_title }}" />
                            </div>
                        </div>
                        @foreach ($product->industry as $index => $industry)
                            <div class="row industry-row">
                                <input type="hidden" name="industry[{{ $index }}][id]" value="{{ $industry['id'] }}"/>
                                <div class="form-group col-sm-12 col-md-5">
                                    <label>Name</label>                                    
                                    <input name="industry[{{ $index }}][name]" type="text" placeholder="Enter Title Name" class="form-control" value="{{ $industry['name'] }}" />
                                </div>
                                <div class="form-group col-sm-12 col-md-5">
                                    <label>Images</label>
                                    <input type="file" name="industry[{{ $index }}][image]" class="form-control"/>
                                    @if($industry['image'] != null)
                                        <img src="{{ $industry['image'] }}" alt="image" class="img-thumbnail" style="width: 100px; height: 100px;">
                                    @endif                                    
                                </div>                               
                                <div class="form-group col-sm-12 col-md-2">
                                    <div class="mt-4">
                                        @if ($index == 0)
                                            <button class="btn btn-primary add-industry" type="button">+</button>
                                        @else
                                            <button class="btn btn-danger remove-industry" data-url="{{ url('delete-industry', $industry['id']) }}" data-id="{{ $industry['id'] }}" type="button">-</button>
                                        @endif
                                    </div>                                    
                                </div>              
                            </div>  
                        @endforeach    
                        <div class="mt-3 extra-industry"></div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
   
@endsection
