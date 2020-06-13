@extends('layouts.app')

@section('content')
    <div class="admin-dashboard flex content-between">
        <x-nav-admin/>
        <x-admin-bg>
            <x-card>
                <x-slot name="title">
                    Customers
                </x-slot>
                @if ($customers->count())
                    <ul>
                        @foreach( $customers as $customer)
                        <x-list class="relative">
                            <div class="w-1/5">{{ $customer->first_name}}</div>
                            <div class="w-1/5">{{ $customer->last_name }}</div>
                            <div class="w-1/5 text-center">{{ $customer->user->email }}</div>
                            
                            <div class="absolute bottom-1">
                            <form action="/admin/customers/{{ $customer->id }}" method="POST" id="delete-{{$customer->id}}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button href="" class="text-red-500 mr-5" form="delete-{{$customer->id}}">delete</button>
                            <a href="/admin/customers/{{ $customer->id }}/edit" class="text-blue-500">Edit</a>
                            </div>
                        </x-list>
                        @endforeach
                    </ul>
                @endif
            </x-card>
            <div class="mt-12 pagination">
                {{
                    $customers->links()
                }}
            </div>
        </x-admin-bg>
    </div>
@endsection