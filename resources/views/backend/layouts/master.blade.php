<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Additional CSS for Bootstrap Toggle -->
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <!-- Toastr CSS for notifications -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    @include('backend.layouts.head')
</head>
<body>
<div class="app-container app-theme-white fixed-sidebar fixed-header body-tabs-line">
    @include('backend.layouts.topbar')
    <div class="app-main">
        @include('backend.layouts.sidebar')
        <div class="app-main__outer">
            <div class="app-main__inner">
                @yield('content')
            </div>
        </div>
    </div>
    <div class="app-wrapper-footer">
        @include('backend.layouts.footer')
        @include('backend.layouts.modal')
        @include('backend.layouts.datatable')
    </div>
</div>

<!-- jQuery -->
 <!-- {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> --}} -->
<!-- Bootstrap JS -->
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script> -->
<!-- Bootstrap Toggle JS -->
<!-- <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script> -->
<!-- Toastr JS for notifications -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@yield('scripts')
</body>
</html>