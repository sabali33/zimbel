@extends('layouts.app')

@section('content')
    <div class="admin-dashboard flex content-between">
        <x-nav-admin/>
        <x-admin-bg>
            <x-slot name="title">
                Editing {{ $page->title }}
            </x-slot>
            @include('page.form', [ 'page' => $page ])
        </x-admin-bg>
    </div>
@endsection