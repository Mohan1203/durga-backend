@extends('layouts.admin')

@section('title', 'Settings')
@section('content')
    <div class="">
        <div class="page-header">
            <h3 class="page-title">
                Settings
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
            <!-- Company Information Section -->
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            Company Information
                        </h4>
                        <form class="pt-3 class-create-form" id="company-info-form" action="{{ route('settings.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Company Logo <span class="text-danger">*</span></label>
                                    <input type="file" name="logo" id="logo" class="form-control" />
                                    @error('logo')
                                        <span class="text-danger mt-5">{{ $message }}</span>
                                    @enderror
                                    @if (isset($settings) && $settings->logo)
                                        <img src="{{ asset($settings->logo) }}" alt="Company Logo" class="mt-2"
                                            style="max-height: 100px">
                                    @endif
                                </div>

                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Years of Experience <span class="text-danger">*</span></label>
                                    <input name="years_experience" type="number" placeholder="Enter Years of Experience"
                                        class="form-control" value="{{ $settings->years_experience ?? '' }}" />
                                    @error('years_experience')
                                        <span class="text-danger mt-5">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Global Partners <span class="text-danger">*</span></label>
                                    <input name="global_partners" type="number"
                                        placeholder="Enter Number of Global Partners" class="form-control"
                                        value="{{ $settings->global_partners ?? '' }}" />
                                    @error('global_partners')
                                        <span class="text-danger mt-5">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Products <span class="text-danger">*</span></label>
                                    <input name="products_count" type="number" placeholder="Enter Number of Products"
                                        class="form-control" value="{{ $settings->products_count ?? '' }}" />
                                    @error('products_count')
                                        <span class="text-danger mt-5">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-sm-12 col-md-6">
                                    <label>State Image <span class="text-danger">*</span></label>
                                    <input type="file" name="state_image" id="state_image" class="form-control" />
                                    @error('state_image')
                                        <span class="text-danger mt-5">{{ $message }}</span>
                                    @enderror
                                    @if (isset($settings) && $settings->state_image)
                                        <img src="{{ asset($settings->state_image) }}" alt="State Image" class="mt-2"
                                            style="max-height: 100px">
                                    @endif
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Save Company Info</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Contact Information Section -->
            {{-- <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            Contact Information
                        </h4>
                        <form class="pt-3 class-create-form" id="contact-info-form"
                            action="{{ route('settings.update', 1) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Phone Number <span class="text-danger">*</span></label>
                                    <input name="phone" type="text" placeholder="Enter Phone Number"
                                        class="form-control" value="{{ $settings->phone ?? '' }}" />
                                    @error('phone')
                                        <span class="text-danger mt-5">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input name="email" type="email" placeholder="Enter Email Address"
                                        class="form-control" value="{{ $settings->email ?? '' }}" />
                                    @error('email')
                                        <span class="text-danger mt-5">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-sm-12">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <textarea name="address" class="form-control" rows="4" placeholder="Enter Complete Address">{{ $settings->address ?? '' }}</textarea>
                                    @error('address')
                                        <span class="text-danger mt-5">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Google Map Link</label>
                                    <input name="map_link" type="text" placeholder="Enter Google Map Embed Link"
                                        class="form-control" value="{{ $settings->map_link ?? '' }}" />
                                    @error('map_link')
                                        <span class="text-danger mt-5">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Working Hours</label>
                                    <input name="working_hours" type="text" placeholder="Ex: Mon-Fri: 9AM to 5PM"
                                        class="form-control" value="{{ $settings->working_hours ?? '' }}" />
                                    @error('working_hours')
                                        <span class="text-danger mt-5">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Save Contact Info</button>
                        </form>
                    </div>
                </div>
            </div> --}}

            <!-- Social Media Links Section -->
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            Social Media Links
                        </h4>
                        <form class="pt-3 class-create-form" id="social-media-form"
                            action="{{ route('settings.update', 2) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Facebook</label>
                                    <input name="facebook" type="url" placeholder="Enter Facebook URL"
                                        class="form-control" value="{{ $settings->facebook ?? '' }}" />
                                </div>

                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Twitter/X</label>
                                    <input name="twitter" type="url" placeholder="Enter Twitter/X URL"
                                        class="form-control" value="{{ $settings->twitter ?? '' }}" />
                                </div>

                                <div class="form-group col-sm-12 col-md-6">
                                    <label>LinkedIn</label>
                                    <input name="linkedin" type="url" placeholder="Enter LinkedIn URL"
                                        class="form-control" value="{{ $settings->linkedin ?? '' }}" />
                                </div>

                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Instagram</label>
                                    <input name="instagram" type="url" placeholder="Enter Instagram URL"
                                        class="form-control" value="{{ $settings->instagram ?? '' }}" />
                                </div>
                                <div class="form-group col-sm-12 col-md-6">
                                    <label>Youtube</label>
                                    <input name="youtube" type="url" placeholder="Enter Youtube URL"
                                        class="form-control" value="{{ $settings->youtube ?? '' }}" />
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Save Social Media</button>
                        </form>
                    </div>
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

        // Handle CSRF token expiration
        $(document).ajaxError(function(event, jqXHR, settings, thrownError) {
            if (jqXHR.status === 419) { // CSRF token mismatch
                refreshToken();
                alert('Your session has expired. Please try again.');
            }
        });

        // Preview uploaded images
        function readURL(input, previewElement) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $(previewElement).attr('src', e.target.result).show();
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(document).ready(function() {
            $("#logo").change(function() {
                readURL(this, '#logo-preview');
            });

            $("#state_image").change(function() {
                readURL(this, '#state-preview');
            });

            // Show success message and fade out
            $('.alert-success').delay(3000).fadeOut(350);
            $('.alert-danger').delay(3000).fadeOut(350);

            // Handle delete functionality
            $('.delete-setting').click(function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to delete this setting?')) {
                    var form = $(this).closest('form');
                    $.ajax({
                        url: form.attr('action'),
                        type: 'DELETE',
                        data: form.serialize(),
                        success: function(response) {
                            if (response.success) {
                                location.reload();
                            } else {
                                alert('Error deleting setting');
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 419) { // CSRF token mismatch
                                refreshToken();
                                alert('Your session has expired. Please try again.');
                            } else {
                                alert('Error deleting setting');
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
