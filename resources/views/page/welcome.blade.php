@extends('layouts.app')

@section('content')
@php
    $docs_url = url('/pages/docs');
@endphp
    <div class="container mt-12 mx-auto">
        <p class="text-xl font-bold mb-8">
            {{ __("Thanks for becoming a pro customer, {$customer->first_name}") }} 
        </p>
       
        <div class="mt-5">
           <p class="mb-5"> {{ __("Please copy this license key to Auto Share settings on your site for activation:") }} </p>
            <code class="select-text"> {{ $license->license_key }} </code>
        </div>
        <p class="mt-12">
            {{ __("Please refer to the documentation at $docs_url for a guide to adding your license key") }}
        </p>
    </div>
    
@endsection