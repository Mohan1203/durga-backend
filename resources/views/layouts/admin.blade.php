<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('/assets/css/vendor.bundle.base.css') }}" async>
    <link rel="stylesheet" href="{{ asset('/assets/fonts/font-awesome.min.css') }}" async />
    <link rel="stylesheet" href="{{ asset('/assets/select2/select2.min.css') }}" async>
    <link rel="stylesheet" href="{{ asset('/assets/jquery-toast-plugin/jquery.toast.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/color-picker/color.min.css') }}" async>

    <link rel="stylesheet" href="{{ asset('/assets/css/datepicker.min.css') }}" async>
    <link rel="stylesheet" href="{{ asset('/assets/css/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/ekko-lightbox.css') }}">

    <link rel="stylesheet" href="{{ asset('/assets/bootstrap-table/bootstrap-table.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/bootstrap-table/fixed-columns.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/bootstrap-table/reorder-rows.css') }}">


    {{-- <link rel="shortcut icon" href="{{asset(config('global.LOGO_SM')) }}" /> --}}
    <link rel="shortcut icon" href="{{ url(Storage::url(env('FAVICON'))) }}" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ URL::asset('index.js') }}"></script>
    <script src="{{ asset('/assets/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('/assets/js/Chart.min.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/assets/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
    <script src="{{ asset('/assets/select2/select2.min.js') }}"></script>

    <script src="{{ asset('/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('/assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('/assets/js/misc.js') }}"></script>
    <script src="{{ asset('/assets/js/settings.js') }}"></script>
    <script src="{{ asset('/assets/js/todolist.js') }}"></script>
    <script src="{{ asset('/assets/js/ekko-lightbox.min.js') }}"></script>


    <script src="{{ asset('/assets/bootstrap-table/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('/assets/bootstrap-table/bootstrap-table-mobile.js') }}"></script>
    <script src="{{ asset('/assets/bootstrap-table/bootstrap-table-export.min.js') }}"></script>
    <script src="{{ asset('/assets/bootstrap-table/fixed-columns.min.js') }}"></script>
    <script src="{{ asset('/assets/bootstrap-table/tableExport.min.js') }}"></script>
    <script src="{{ asset('/assets/bootstrap-table/jspdf.min.js') }}"></script>
    <script src="{{ asset('/assets/bootstrap-table/jspdf.plugin.autotable.js') }}"></script>
    <script src="{{ asset('/assets/bootstrap-table/jquery.tablednd.min.js') }}"></script>
    <script src="{{ asset('/assets/bootstrap-table/reorder-rows.min.js') }}"></script>
    <script src="{{ asset('/assets/bootstrap-table/loadash.min.js') }}"></script>


    <script src="{{ asset('/assets/js/jquery.cookie.js') }}"></script>
    <script src="{{ asset('/assets/js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('/assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('/assets/js/datepicker.min.js') }}"></script>
    <script src="{{ asset('/assets/js/daterangepicker.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery.repeater.js') }}"></script>

    <script src="{{ asset('/assets/color-picker/jquery-asColor.min.js') }}"></script>
    <script src="{{ asset('/assets/color-picker/color.min.js') }}"></script>
    <script src="{{ asset('/assets/js/custom/function.js') }}"></script>
    <script src="{{ asset('/assets/js/jquery-additional-methods.min.js') }}"></script>

    <script src="{{ asset('/assets/js/custom/custom.js') }}"></script>
    <script src="{{ asset('/assets/js/custom/custom-bootstrap-table.js') }}"></script>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script type='text/javascript'>
                $.toast({
                    text: '{{ $error }}',
                    showHideTransition: 'slide',
                    icon: 'error',
                    loaderBg: '#f2a654',
                    position: 'top-right'
                });
            </script>
        @endforeach
    @endif

    @if (Session::has('success'))
        <script>
            $.toast({
                text: '{{ Session::get('success') }}',
                showHideTransition: 'slide',
                icon: 'success',
                loaderBg: '#f96868',
                position: 'top-right'
            });
        </script>
    @endif

    <script>
        $(document).on('click', '.deletedata', function() {
            Swal.fire({
                title: "{{ __('delete_title') }}",
                text: "{{ __('confirm_message') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ __('yes_delete') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: $(this).attr('data-url'),
                        type: "DELETE",
                        success: function(response) {
                            if (response['error'] == false) {
                                showSuccessToast(response['message']);
                                $('#table_list').bootstrapTable('refresh');
                            } else {
                                showErrorToast(response['message']);
                            }
                        }
                    });
                }
            })
        });
    </script>

</head>

<body>
    <!-- Sidebar and Main Layout -->
    <div class="d-flex main-content">
        <!-- Sidebar -->
        <div class="">
            @include('partials.sidebar')
        </div>

        <!-- Main Content -->
        <div class="main-panel w-100 ">
            @include('partials.navbar')
            <div class="content-wrapper container-fluid ">
                @yield('content')
            </div>
        </div>
    </div>
</body>

</html>
