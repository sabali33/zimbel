@extends('layouts.app')

@section('content')
    <div class="admin-dashboard flex content-between">
        <x-nav-admin/>
        <x-admin-bg>
            <x-slot name="title">
                New Page
            </x-slot>
            @include('page.form', [ 'page' => null ])
        </x-admin-bg>
    </div>
@endsection