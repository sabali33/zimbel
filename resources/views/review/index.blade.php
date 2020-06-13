@extends('layouts.app')

@section('content')
    <div class="admin-dashboard flex content-between">
        <x-nav-admin/>
        <x-admin-bg>
            <p class="mb-10">
                <a href="/admin/reviews/create" class=" bg-blue-500 px-4 py-2 rounded text-white hover:shadow-md transition ease-in duration-300">Add Review</a>
            </p>
            <x-card>
                <x-slot name="title">
                    Reviews
                </x-slot>
                @if($reviews->count())
                <ul>
                    @foreach( $reviews as $review)
                     <x-list class="relative">
                         <div class="w-1/5">{{ $review->title }}</div>
                         <div class="w-1/5">{{ $review->full_name }}</div>
                         <div class="w-1/5 text-center">{{ $review->user_id }}</div>
                         <div class="w-1/5">{{ $review->rate }}</div>
                         <div class="w-1/5">{{ $review->ip_address }}</div>
                         
                         <div class="absolute bottom-0">
                         <form action="/admin/reviews/{{ $review->id }}" method="POST" id="delete-{{$review->id}}">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button href="" class="text-red-500 mr-5" form="delete-{{$review->id}}">delete</button>
                        <a href="/admin/reviews/{{ $review->id }}/edit" class="text-blue-500">Edit</a>
                         </div>
                     </x-list>
                    @endforeach
                </ul>
                @else
                <p class="text-center p-5 text-gray-500"> <i>No reviews added yet</i></p>
                @endif
            </x-card>
            <div class="pagination mt-10">
                {{
                    $reviews->links()
                }}
            </div>
            
        </x-admin-bg>
            
    </div>
@endsection