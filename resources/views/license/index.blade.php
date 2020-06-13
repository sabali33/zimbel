@extends('layouts.app')

@section('content')
    <div class="admin-dashboard flex content-between">
        <x-nav-admin/>
        <x-admin-bg>
            <x-nav-bar logo="0"/>
            <p class="mb-10">
                <a href="/admin/licenses/create" class=" bg-blue-500 px-4 py-2 rounded text-white hover:shadow-md transition ease-in duration-300">Add License</a>
            </p>
            <x-card>
                <x-slot name="title">
                    Licenses
                </x-slot>
                
                @if($licenses->count())
                    <ul>
                        @foreach( $licenses as $license)
                        
                            <x-list class="relative">
                                <div class="w-1/5">{{ $license->id }}</div>
                                <div class="w-1/5">{{ $license->customer->first_name }}</div>
                                <div class="w-1/5 text-center">{{ $license->product->title }}</div>
                                <div class="w-1/5">{{ $license->license_key}}</div>
                                <div class="w-1/5">{{ $license->expiry_date}}</div>
                                <div class="absolute bottom-1">
                                    <form action="/admin/licenses/{{ $license->id }}" method="POST" id="delete-{{$license->id}}">
                                        @csrf
                                            @method('DELETE')
                                    </form>
                                    <button class="text-red-500 mr-5" form="delete-{{$license->id}}">delete</button>
                                </div>
                            </x-list>
                            
                        @endforeach
                    </ul>
                @else
                <p class="text-center p-5 text-gray-500"> <i>No licenses added yet</i></p>
                @endif
            </x-card>
            <div class="pagination mt-12">
                @if (method_exists($licenses, 'links'))
                   {{
                        $licenses->links()
                    }} 
                @endif
                
            </div>
        </x-admin-bg>
    </div>
@endsection