@extends('layouts.app')

@section('content')
@php
    $target = "/admin/products/{$product->id}";
@endphp
<x-nav-admin/>
<x-admin-bg>
    <x-slot name="title">
        Editing Product {{ $product->title }}
    </x-slot>
    <div class="new-product-form-box">
        @include('product.form', compact('product', 'target'))
    </div>
</x-admin-bg>
@endsection