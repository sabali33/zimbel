@extends('layouts.app')

@section('content')
    <x-nav-admin/>
    <x-admin-bg>
        <x-slot name="title">
            Editing Review by {{ $review->full_name }}
        </x-slot>
        <div class="edit-review-form-box">
            @include('review.form', ['target' => "/admin/reviews/$review->id", 'review' => $review])
        </div>
    </x-admin-bg>
@endsection