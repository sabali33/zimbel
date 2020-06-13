@extends('layouts.app')

@section('content')
    <div class="admin-dashboard flex content-between">
        <x-nav-admin/>
        <x-admin-bg>
            <x-slot name="title">
                New License
            </x-slot>
            <div class="new-license-form-box">
                <form action="/admin/licenses" method="POST">
                    @csrf
                    <p class="mb-12">
                        <label for="search-customers" class="inline-block mb-5">Find Customer</label>
                        <input type="search" name="search_customers" id="search-customers" class="w-full px-5 py-3 rounded searchable" data-model="customer">
                        <ul class="suggested-customer-list w-1/3 shadow p-5 hidden bg-white"></ul>
                    </p>
                    <p class="mb-12">
                        <label for="search-products" class="inline-block mb-5">Find Product</label>
                        <input type="text" name="search_product" id="search-products" class="w-full px-5 py-3 rounded searchable" data-model="product">
                        <ul class="suggested-product-list"></ul>
                    </p>
                    <p class="mb-12">
                        <label for="expire-date" class="inline-block mb-5">Expiry Date</label>
                        <input type="date" name="expiry_date" id="expire-date" class="w-full px-5 py-3 rounded">
                    </p>
                    <p>
                        <button class="px-4 py-2 bg-blue-500 rounded text-white">Generate License</button>
                    </p>
                </form>
            </div>
        </x-admin-bg>
    </div>
@endsection