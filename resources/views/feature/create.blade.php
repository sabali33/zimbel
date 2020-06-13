@extends('layouts.app')

@section('content')
    <x-nav-admin/>
    <x-admin-bg>
        <x-slot name="title">
            New Feature 
        </x-slot>
        <div class="new-feature-form-box">
            @include('feature.form', ['target' => '/admin/features', 'feature' => false])
        </div>
    </x-admin-bg>
@endsection