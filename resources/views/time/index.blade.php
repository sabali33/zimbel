@extends('layouts.app')

@section('content')
    <div class="admin-dashboard flex content-between">
        <x-nav-admin/>
        <x-admin-bg>
            {{-- <p class="mb-10">
                <a href="/times/create" class=" bg-blue-500 px-4 py-2 rounded text-white hover:shadow-md transition ease-in duration-300">Add Time</a>
            </p> --}}
            <x-card>
                <x-slot name="title">
                    Times
                </x-slot>
                @foreach( $times as $time )
                    <x-list>
                        {{
                            $time
                        }}
                    </x-list>
                @endforeach
            </x-card>
            
        </x-admin-bg>
    </div>
@endsection