<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 h-screen antialiased leading-none text-gray-800">
    <div id="app">
        @guest
            <x-nav-bar logo="1"/>
        @endguest
        @if(!Request::is('admin/*') && Auth::user())
        <div class="ml-12 mt-12">
            <a href="/dashboard" class="bg-gray-900 text-white px-4 py-2 rounded">Go to Dashboard</a>
        </div>
            
        @endif   
        @yield('content')
    </div>
    
</body>
</html>
