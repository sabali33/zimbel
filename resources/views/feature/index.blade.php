@extends('layouts.app')

@section('content')
    <div class="admin-dashboard flex content-between">
        <x-nav-admin/>
        <x-admin-bg>
            
            <p class="mb-10">
                <a href="/admin/features/create" class=" bg-blue-500 px-4 py-2 rounded text-white hover:shadow-md transition ease-in duration-300">Add Feature</a>
            </p>
            <x-card>
                <x-slot name="title">
                    Features
                </x-slot>
                @if($features->count())
                <ul>
                    @foreach( $features as $feature)
                     <x-list class="relative">
                         <div class="w-1/5">{{ $feature->name}}</div>
                         <div class="w-1/5">{{ $feature->alias }}</div>
                         @isset($feature->product->tilte)
                            <div class="w-1/5">{{  $feature->product->title }}</div>
                         @endisset
                         <div class="absolute bottom-0 bottom-1">
                         <form action="/admin/features/{{ $feature->id }}" method="POST" id="delete-{{$feature->id}}">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button href="" class="text-red-500 mr-5" form="delete-{{$feature->id}}">delete</button>
                        <a href="/admin/features/{{ $feature->id }}/edit" class="text-blue-500">Edit</a>
                         </div>
                     </x-list>
                    @endforeach
                </ul>
                @else
                <p class="text-center p-5 text-gray-500"> <i>No features added yet</i></p>
                @endif
            </x-card>
            <div class="pagination mt-10">
                {{
                    $features->links()
                }}
            </div>
            
        </x-admin-bg>
            
    </div>
@endsection