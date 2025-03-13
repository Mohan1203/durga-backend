<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('style.css')}}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ URL::asset('index.js') }}"></script>

</head>
<body>
    <!-- Sidebar and Main Layout -->
    <div class="d-flex">
        <!-- Sidebar -->
        <div>
            @include('partials.sidebar')
        </div>

        <!-- Main Content -->
        <div class="main-panel w-100">
            @include('partials.navbar')
            <div class="content-wrapper container-fluid ">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
