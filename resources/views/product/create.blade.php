@extends('layouts.app')

@section('content')
    <x-nav-admin/>
    <x-admin-bg>
        <x-slot name="title">
            New Product
        </x-slot>
        <div class="new-product-form-box">
            @include('product.form', ['target' => '/admin/products', 'product' => false])
        </div>
    </x-admin-bg>
@endsection