@extends('errors.minimal')

@section('title', __('Unauthorized'))

@section('code')

{{__('401') }}

@endsection

@section('message', __('Unauthorized'))
