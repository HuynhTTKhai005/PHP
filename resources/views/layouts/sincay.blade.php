<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sincay Restaurant - Nhà hàng ngon nhất')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/icons/logo.png') }}" />

    <!-- CSS Libraries -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/themify/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/animate/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/css-hamburgers/hamburgers.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/animsition/css/animsition.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/slick/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/lightbox2/css/lightbox.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/cart.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Isotope CDN -->
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    @stack('styles')
</head>

<body class="animsition" data-use-reload="1" data-reload-url="{{ route('reload') }}">
    {{-- <div id="page-loader" class="page-loader is-hidden" aria-hidden="true">
        <div class="page-loader__spinner"></div>
        <p class="page-loader__text">Đang tải trang...</p>
    </div> --}}
    <!-- Header -->
    @include('partials.header')
    @if (session('success'))
        <div id="app-notice" data-type="success" data-message="{{ session('success') }}"></div>
    @endif
    @if (session('error'))
        <div id="app-notice" data-type="error" data-message="{{ session('error') }}"></div>
    @endif
    @if (!session('success') && !session('error') && $errors->any())
        <div id="app-notice" data-type="error" data-message="Vui lòng kiểm tra lại thông tin nhập!"></div>
    @endif
    <div id="app-notification" class="app-notification app-notification--hidden" aria-live="assertive">
        <div class="app-notification__backdrop"></div>
        <div class="app-notification__card" role="alertdialog" aria-modal="true">
            <div class="app-notification__icon" aria-hidden="true"></div>
            <div class="app-notification__content">
                <p class="app-notification__message"></p>
            </div>
            <button type="button" class="app-notification__close" aria-label="Đóng thông báo">Đóng</button>
        </div>
    </div>
    @yield('content')
    @include('partials.footer')
    <!-- Back to top -->
    <div class="btn-back-to-top bg0-hov" id="myBtn">
        <span class="symbol-btn-back-to-top ">
            <i class="fa fa-angle-double-up" aria-hidden="true"></i>
        </span>
    </div>
    <!-- JS Libraries -->
    <script src="{{ asset('assets/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/animsition/js/animsition.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/slick/slick.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick-custom.js') }}"></script>
    <script src="{{ asset('assets/vendor/parallax100/parallax100.js') }}"></script>
    <script src="{{ asset('assets/vendor/countdowntime/countdowntime.js') }}"></script>
    <script src="{{ asset('assets/vendor/lightbox2/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
