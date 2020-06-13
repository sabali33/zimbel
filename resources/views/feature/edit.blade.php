@extends('layouts.app')

@section('content')
@php
    $target = "/admin/features/{$feature->id}";
@endphp
<x-nav-admin/>
<x-admin-bg>
    <x-slot name="title">
        Edit Feature ({{ $feature->name }})
    </x-slot>
    <div class="new-feature-form-box">
        @include('feature.form', compact('feature', 'target'))
    </div>
</x-admin-bg>
@endsection