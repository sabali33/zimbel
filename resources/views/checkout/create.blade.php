@extends('layouts.checkout')

@section('content')
    <div class="product-info flex mb-10 mt-12 justify-between w-2/3 mx-auto">
        <div class="font-bold">{{ $product->title }}</div>
        <div class="font-bold">${{ $product->price }} / year</div>
    </div>
    <hr class="w-2/3 mx-auto border border-opacity-25 border-gray-500">
    <form action="/admin/customers" class="w-2/3 mt-10 mx-auto" method="post" id="create-customer">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <p class="mb-12">
            <label for="first-name" class="mb-5 inline-block">First Name</label>
            <input type="text" name="first_name" class=" field w-full px-5 py-3 rounded border border-opacity-25 border-gray-500 focus:outline-none focus:shadow" value="{{ old('first_name') }}">
            @error('first_name')
                <span class="text-red-500">
                    {{ $message }} 
                </span>
            @enderror
        </p>
        <p class="mb-12">
            <label for="last-name" class="mb-5 inline-block">Last Name</label>
            <input type="text" name="last_name" class="field w-full px-5 py-3 rounded border border-opacity-25 border-gray-500 focus:outline-none focus:shadow" value="{{ old('last_name') }}">
            @error('last_name')
                <span class="text-red-500">
                    {{ $message }} 
                </span>
            @enderror
        </p>
        <p class="mb-12">
            <label for="email" class="mb-5 inline-block">Email</label>
            <input type="email" name="email" class="field w-full px-5 py-3 rounded border border-opacity-25 border-gray-500 focus:outline-none focus:shadow" value="{{ old('email') }}">
            @error('email')
                <span class="text-red-500">
                    {{ $message }} 
                </span>
            @enderror
        </p>
        <p class="mb-12" >
            <label for="website" class="mb-5 inline-block">Website on which plugin will be used</label>
            <input type="url" name="api_site" class="field w-full px-5 py-3 rounded border border-opacity-25 border-gray-500 focus:outline-none focus:shadow" value="{{ old('api_site') }}">
            @error('api_site')
                <span class="text-red-500">
                   {{ $message }} 
                </span>
                
            @enderror
        </p>
        <input type="hidden" name="_payment_token" id="paid" value="{{ old('_payment_token') }}">
        @error('_payment_token')
            <span class="text-red-500">
                {{ $message }} 
            </span>
        @enderror
        <input type="hidden" name="billing_address" id="billing-address" value="{{ old('billing_address') }}">
        @error('billing_address')
            <span class="text-red-500">
                {{ $message }} 
            </span>
        @enderror
        <input type="hidden" name="shipping_address" id="shipping-address" value="{{ old('shipping_address') }}">
        @error('shipping_address')
            <span class="text-red-500">
                {{ $message }} 
            </span>
        @enderror
        <p class="mb-12">
            @if (old('_payment_token') || old('_worldpay_token'))
                <button class="bg-blue-500 px-4 py-2 rounded text-white shadow">
                    {{ __('Continue to pay') }}
                </button>
            @else
                {{-- <span id="gpay-box"></span> --}}
                <div class="my-12">
                    <h3 class="my-12 font-bold"> Add billing address for verification </h3>
                    <p class="mb-10">
                        <label for="address1" class="mb-5 inline-block">Address 1</label>
                        <input type="text" name="address1" class="w-full rounded px-5 border border-opacity-25 border-gray-500 py-3 focus:outline-none focus:shadow" id="address1">
                    </p>
                    <p class="mb-10">
                        <label for="postcode" class="mb-5 inline-block">Post Code</label>
                        <input type="text" name="postalCode" id="postcode" class="w-full border border-opacity-25 border-gray-500 focus:outline-none focus:shadow rounded px-5 py-3">
                    </p>
                    <p class="mb-10">
                        <label for="city" class="mb-5 inline-block">City</label>
                        <input type="text" name="city" id="city" class="w-full rounded px-5 py-3 border border-opacity-25 border-gray-500 focus:outline-none focus:shadow">
                    </p>
                    <p class="mb-10">
                        <label for="countryCode" class="mb-5 inline-block">Country</label>
                        <input type="text" name="countryCode" id="countryCode" class="w-full rounded py-3 px-5 border border-opacity-25 border-gray-500 focus:outline-none focus:shadow">
                    </p>
                </div>
                <div id="worldpay-section" class="w-full"></div>
               
                <div class="mt-12">
                    <button class="bg-blue-500 font-bold px-4 py-2 rounded text-white" onclick="Worldpay.submitTemplateForm()">Pay</button>
                   
                </div>
            @endif
             
        </p>
    </form>
@endsection