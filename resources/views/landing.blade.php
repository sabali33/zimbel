<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="bg-gray-100 h-screen antialiased leading-none">
<div class="container mx-auto flex flex-col content-between">
    <header class="mt-12">
    <span>
        <img src="{{ url('images/logo.jpg')}}" alt="Zimbel Digits" class="w-12">
    </span>
    </header>
    <div class="checkout-box mt-12">
        <div class="modal sm:w-full md:w-2/3 md:w-full bg-white shadow-md mx-auto p-10 rounded-md text-center">
            <h2 class="text-2xl text-gray-900 capitalize mb-12 font-bold">{{ $product->title }}</h2>
            <div class="text-align flex content-between flex-col border border-gray-500 sm:w-full md:w-1/3  mx-auto rounded-md sm:p-8 p-10 ">
                <h3 class="uppercase mb-6 font-bold text-gray-500">Subscribe</h3>
                <p class="mb-10">
                    <span class="text-gray-500">$</span> 
                    <span class="text-2xl font-bold text-blue-500">{{ $product->price }}</span> <br>
                    <small>a year</small>
                </p>
                
                <ul class="mx-auto text-left text-gray-500 mb-10">
                    @if($product->features->count())
                        @foreach( $product->features as $feature )
                            <li class="mb-5 capitalize leading-6 px-6 relative">
                                <span class="icon icon-check-circle absolute -ml-6 top-5-p">
                                </span>
                                {{ $feature->name }}
                            </li>
                        @endforeach
                    @endif
                    
                </ul>
                <a href="/pay/{{ $product->id }}" class="w-1/2 sm:px-2 transition ease-out duration-200 rounded font-bold py-3 border border-blue-500 text-blue-500 hover:shadow-md mx-auto">Upgrade Now</a>
            </div>
            
        </div>
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
</body>
</html>
