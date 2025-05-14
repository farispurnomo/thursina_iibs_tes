<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name') }} @if(isset($pagetitle)) | {{ $pagetitle }} @endif</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="{{ config('app.name') }}"/>
    <meta name="og:title" content="{{ config('app.name') }}"/>
    <meta name="og:url" content="{{ url()->current() }}"/>
    <meta name="og:image" itemprop="image" content="{{ asset('images/logo_long.png') }}"/>
    <meta name="og:image:url" itemprop="image" content="{{ asset('images/logo_long.png') }}"/>
    <meta name="og:image:type" content="image/png"/>
    <meta name="og:type" content="article"/>
    <meta name="og:locale" content="id_ID"/>

    <link rel="stylesheet" href="{{ asset('vendor/template/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free-6.1.1-web/css/all.min.css') }}"/>

    <link rel="stylesheet" href="{{ asset('vendor/template/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/template/vendor/css/theme-default.css') }}" class="template-customizer-theme-css"/>
    <link rel="stylesheet" href="{{ asset('vendor/template/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" class="template-customizer-theme-css"/>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}" />

    <link rel="shortcut icon" href="{{ asset('images/logo_short.png') }}" type="image/png"/>

    @yield('styles')

</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('partials.admin.sidebar')

            <div class="layout-page">
                @include('partials.admin.navbar')

                <div class="content-wrapper">
                    @yield('content')

                    @include('partials.admin.footer')

                    <div class="content-backdrop fade"></div>
                </div>
            </div>

            <div class="layout-overlay layout-menu-toggle"></div>
        </div>
    </div>

    <script src="{{ asset('vendor/template/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('vendor/template/js/config.js') }}"></script>
    <script src="{{ asset('vendor/template/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('vendor/template/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('vendor/template/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('vendor/template/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('vendor/template/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('vendor/template/js/main.js') }}"></script>

    <script src="{{ asset('vendor/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>

    @yield('scripts')
</body>

</html>