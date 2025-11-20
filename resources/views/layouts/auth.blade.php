<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @php
        $appName = \App\Models\Setting::get('app_name', 'PKL SMK');
        $appLogo = \App\Models\Setting::get('app_logo');
    @endphp
    <title>@yield('title', $appName)</title>

    @if($appLogo)
        <link rel="icon" type="image/png" href="{{ asset($appLogo) }}">
    @endif

    <!-- Fonts & styles dari SB Admin 2 -->
    <link href="{{ asset('sb-admin-2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('sb-admin-2/css/sb-admin-2.min.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body class="bg-gradient-primary">

<div class="container">
    @yield('content')
</div>

<script src="{{ asset('sb-admin-2/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('sb-admin-2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('sb-admin-2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('sb-admin-2/js/sb-admin-2.min.js') }}"></script>

@stack('scripts')
</body>
</html>
