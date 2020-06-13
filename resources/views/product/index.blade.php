@extends('layouts.app')

@section('content')
    <div class="admin-dashboard flex content-between">
        <x-nav-admin/>
        <x-admin-bg>
            <x-nav-bar logo="0"/>
            <p class="mb-10">
                <a href="/admin/products/create" class=" bg-blue-500 px-4 py-2 rounded text-white hover:shadow-md transition ease-in duration-300">Add Product</a>
            </p>
            <x-card>
                <x-slot name="title">
                    Products
                </x-slot>
                @if($products->count())
                    <ul>
                        @foreach( $products as $product)
                        <x-list class="relative">
                            <div class="w-1/5">{{ $product->title }}</div>
                            <div class="w-1/5">{{ $product->description }}</div>
                            <div class="w-1/5 text-center">{{ $product->user_id }}</div>
                            <div class="w-1/5">{{ $product->link }}</div>
                            <div class="w-1/5">{{ $product->features ? $product->features->count() : 0 }}</div>
                            <div class="absolute bottom-1">
                            <form action="/admin/products/{{ $product->id }}" method="POST" id="delete-{{$product->id}}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button href="" class="text-red-500 mr-5" form="delete-{{$product->id}}">delete</button>
                            <a href="/admin/products/{{ $product->id }}/edit" class="text-blue-500">Edit</a>
                            </div>
                        </x-list>
                        @endforeach
                    </ul>
                @else
                <p class="text-center p-5 text-gray-500"> <i>No products added yet</i></p>
                @endif
            </x-card>
            <div class="pagination mt-10">
                {{
                    $products->links()
                }}
            </div>
            
        </x-admin-bg>
            
    </div>
@endsection