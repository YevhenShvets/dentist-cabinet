<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title></title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/flipper.css') }}" rel="stylesheet">
</head>
<body class="">
        
    <div class="text-center">
        <h3>На даний момент, сторінка ще не створена</h3>
    </div>

    <div class="text-center relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        @if (Route::has('login'))
            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                @auth
                    <a href="{{ url('/home') }}" class="btn btn-success text-sm text-gray-700 underline">Головна сторінка</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary text-sm text-gray-700 underline">Авторизація</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-info ml-4 text-sm text-gray-700 underline">Реєстрація</a>
                    @endif
                @endauth
            </div>
        @endif

    </div>
</body>
</html>
