@extends('layouts.app')

@section('content')
    <x-nav-admin/>
    <x-admin-bg>
        <x-slot name="title">
            New Review
        </x-slot>
        <div class="new-review-form-box">
            @include('review.form', ['target' => '/admin/reviews', 'review' => false])
        </div>
    </x-admin-bg>
@endsection