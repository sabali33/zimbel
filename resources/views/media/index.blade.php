@extends('layouts.app')


@section('content')
<div class="admin-dashboard flex content-between">
    <x-nav-admin/>
    <x-admin-bg>
    
        <p class="mb-10">
            <a href="/admin/media/create" class="add-media bg-blue-500 px-4 py-2 rounded text-white hover:shadow-md transition ease-in duration-300">Upload File</a>
        </p>
        <x-card>
            <x-slot name="title">
                All Files
            </x-slot>
            @if($media)
                <ul>
                    @foreach( $media as $file )
                        <x-list class="h-40">
                        <a href="/{{ $file->disk }}/{{ $file->directory}}/{{ $file->filename}}.{{ $file->extension}}"   data-media="{{ $file->id }}">
                                <img src="/{{ $file->disk }}/{{ $file->directory}}/{{ $file->filename}}.{{ $file->extension}}" alt="{{ $file->filename}}" class="h-full w-40 object-cover">
                        </a>
                        <div class="controls">
                            <span class="edit icon icon-edit">
                                <a href="/admin/media/{{$file->id}}/edit">Edit</a>
                            </span>
                            <span class="delete icon icon-bin">
                                <button class="text-red-500" form="delete-{{ $file->id }}">Delete</button>
                            </span>
                            <form action="/admin/media/{{ $file->id }}" id="delete-{{ $file->id }}" method="POST">
                            @method("delete")
                            @csrf
                            </form>
                        </div>
                        </x-list>
                    @endforeach
                </ul>
            @endif
        </x-card>
        <div class="pagination mt-12">
            {{
                $media->links()
            }}
        </div>
    </x-admin-bg>
    <div class="media-modal-box fixed bg-gray-500 bg-opacity-50 inset-0 hidden">

    </div>
    @csrf
</div>
@endsection