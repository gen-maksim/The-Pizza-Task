<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pizza registration</title>

    <!-- Fonts -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<section>
    <nav class="navbar sticky-nav" role="navigation" aria-label="main navigation" style="background-color: #f4faf7">
        <div class="navbar-menu is-active">
            <div class="navbar-end">
                <div class="navbar-item">
                    <a class="button is-light" href="{{ route('login') }}">
                        Log in
                    </a>
                    <a class="button is-light" href="{{ route('menu') }}">
                        Menu
                        <i class="fas fa-pizza-slice"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>
    @yield('content')
</section>
</body>

<script src="{{ asset('js/app.js') }}"></script>
</html>
