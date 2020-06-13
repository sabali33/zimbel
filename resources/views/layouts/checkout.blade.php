<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Zimbel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="bg-gray-100 h-screen antialiased leading-none">
    <div class="container mx-auto flex flex-col content-between">
        <header class="mt-12">
        <span>
            <img src="{{ url('images/logo.jpg') }}" alt="Zimbel Digits" class="w-12">
        </span>
        </header>
        <div class="checkout-box mt-12">
            @if (session('status'))
                <div class="text-red-500">
                    {{ session('status') }}
                </div>
            @endif
            @yield('content')
        </div>
        <footer class="mt-32">
            <hr>
            <p class="text-gray-600 py-3 border-t-1"> Zimbel Copyright 2020</p>
            <hr class="border-t-4 border-blue-500">
        </footer>
    </div>
    <script async
  src="https://pay.google.com/gp/p/js/pay.js"
  ></script>
  <script src="https://cdn.worldpay.com/v1/worldpay.js"></script >
</body>
</html>
