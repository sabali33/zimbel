@extends('layouts.app')

@section('content')
    <div class="admin-dashboard flex content-between">
        <x-nav-admin/>
        <x-admin-bg>
            <x-nav-bar logo="0"/>
            <p class="mb-10">
                <a href="/admin/pages/create" class=" bg-blue-500 px-4 py-2 rounded text-white hover:shadow-md transition ease-in duration-300">Add Page</a>
            </p>
            <x-card>
                <x-slot name="title">
                    Pages
                </x-slot>
                @if($pages)
                    <ul>
                        @foreach( $pages as $page )
                            <x-list class="h-20 relative">
                                <div class="mr-2">#{{ $page->id }}</div>
                                <div class="mr-2">{{ $page->title }}</div>
                                <div class="mr-2">{{ trim($page->content) }}</div>
                                <div class="mr-2">{{ $page->author->name }}</div>
                                <div class="mr-2">category</div>
                                <div class="controls absolute bottom-1">
                                    <span class="mr-5">
                                        <a href="/admin/pages/{{$page->id}}/edit" class="text-blue-500"> Edit </a>
                                    </span>
                                    <span>
                                        <button class="text-red-500" form="delete-page">Delete</button>
                                        <form action="/admin/pages/{{ $page->id }}" id="delete-page" method="post">
                                        @csrf
                                        @method('DELETE')
                                        </form>
                                    </span>
                                </div>
                            </x-list>

                            
                        @endforeach
                    </ul>
                @endif
            </x-card>
            
        </x-admin-bg>
    </div>
@endsection