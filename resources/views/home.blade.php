@extends('layouts.app')
@php
    $hero_meta = $page ? $page->meta->where('meta_key', 'hero-text')->first() : null; 
    $hero_message = $hero_meta ? $hero_meta->meta_value : "Welcome";
    $download_message_meta = $page ? $page->meta->where('meta_key', 'download-message')->first() : null;
    $download_message_text = $download_message_meta ? $download_message_meta->meta_value : '';
@endphp
@section('content')
    <div class="container mx-auto">
        <section class="section mb-24">
            <h2 class=" text-4xl md:text-5xl mb-10 hyphen text-gray-900 font-bold px-5 text-center">
                {{ $product->title }}
            </h2>
            <p class="text-center mb-6"> 
                <a href="#" class="font-bold text-gray-900">{{ $download_message_text }}</a> 
            </p>
            <p class="mb-6 text-center">
                <span>or</span>
            </p>
            <p class="mb-6 text-center">
                <a href="/checkout" class="border border-blue-500 shadow hover:bg-gray-500 px-2 sm:px-5 py-2 rounded hover:text-blue-500 transition ease-out duration-200">
                Upgrade to premium version
            </a>
            </p>
            
        </section>
        <section class="section mb-12">
            <h2 class="text-2xl mb-10 capitalize font-bold text-gray-900 text-center">WHY SAAS AUTO SHARE PLUGIN?</h2>
            <ul class="text-gray-600 m-auto col-auto columns">
                @foreach( $product->features as $feature )
                <li class="mb-4">
                    
                    <h4 class="font-bold">
                        <span class="icon icon-check-circle"></span>
                        {{
                            $feature->name
                        }}
                    </h4>
                    <div class="content mt-3 ml-12">
                        {{
                            $feature->alias
                        }}
                    </div>
                    
                    
                </li>
                @endforeach
                
            </ul>
        </section>
        <section class="section text-center mb-40">
            <h2 class="text-2xl mb-10 capitalize font-bold text-gray-900">WHAT ARE OUR CUSTOMERS SAYING ABOUT US</h2>
            <ul class="w-2/3 text-center mx-auto col-2">
                @foreach( $product->reviews as $review )
                    <li class="mb-4 flex">
                        <img src="#" alt="reviewer name" class="w-12">
                        <div class="ml-6">
                            <p class="text-left mb-3 text-gray-900 font-bold"> {{ $review->full_name }}</p>
                            <p class="text-left mb-3 text-gray-500"> <i>{{ $review->title }}</i> </p>
                            <p class="text-left mb-3 leading-5 text-gray-600">
                                {{ $review->remark }}
                            </p>
                            <p class="mt-5">
                                <span class="icon icon-star-empty"> </span>
                            </p>
                        </div>
                    </li>
                @endforeach
               
            </ul>
        </section>
        <footer class="">
            <hr>
            <p class="text-gray-600 py-3 border-t-1"> Zimbel Copyright 2020</p>
            <hr class="border-t-4 border-blue-500">
        </footer>
    </div>
@endsection
