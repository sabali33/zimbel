@php
    $title = $page ? $page->title : '';
    $content = $page ? $page->content : '';
    $action = $page ? "/admin/pages/$page->id" : '/admin/pages';
    $last_meta = $page && $page->meta ? $page->meta->last() : null;
    $meta_count = $last_meta ? $last_meta : 0;
@endphp
<form action="{{  $action }}" method="post" enctype="multipart/form-data" class="flex">
    @csrf
    @if( $page )
        @method('PUT')
    @endif
    <div class="w-2/3">
        <p class="mb-12">
            <label for="title" class="mb-5 inline-block">Title</label>
        <input type="text" id="title" name="title" class="w-full px-5 py-3 rounded" value="{{ $title }}">
        </p>
        <p class="mb-12">
            <label for="content" class="mb-5 inline-block">Content</label>
            <textarea name="content" id="content" cols="30" rows="10" class="w-full px-5 py-3 rounded">{{ $content }}</textarea>
        </p>
        <p class="mb-12">
            <label for="user-id" class="mb-5 inline-block">Author</label>
            <select name="user_id" id="user-id" class="w-full h-12 py-3 rounded">
                
                @if(isset($users))
                    @foreach( $users as $user)
                    @php
                        $selected = $page  && $page->author->id === $user->id ? 'selected' : '';
                    @endphp
                        <option value="{{ $user->id}}" {{ $selected }}> {{ $user->name }} </option>
                    @endforeach
                @endif
            </select>
        </p>

        <div class="mb-12 meta-box-container">
            
        <div class="meta-form-box" data-metacount="{{ $meta_count  }}">
                @if(isset($page->meta))
                    @foreach( $page->meta as $key => $meta )
                        <div class="meta-item flex items-center mb-5">
                            <div class="w-1/2">
                                <label for="meta" class="mb-3 inline-block" > Meta Key </label>
                                <input name="meta[{{$meta->id}}][]" class="w-full rounded px-5 py-3 rounded" value="{{ $meta->meta_key}}"/>
                            </div>
                            <div class="w-1/2 ml-5">
                                <label for="value" class="mb-3 inline-block" > Meta Value </label>
                                <input name="meta[{{$meta->id}}][]" class="w-full rounded px-5 py-3 rounded" value="{{ $meta->meta_value }}"/>
                            </div>
                            <span class="icon icon-times text-red-500 self-end w-20 text-3xl close cursor-pointer"> </span>
                        </div>
                    @endforeach
                @endif
            </div>
            <span class="add-meta-form icon icon-plus cursor-pointer text-blue-500">Add Meta</span>
            
        </div>
        <p class="mb-10">
            <button class="bg-blue-500 px-4 py-2 rounded text-white"> {{ is_null($page) ? 'Create' : 'update' }} </button>
        </p>
        
    </div>
    
    <div class="w-1/3 ml-12">
        <p class="mb-10">
            <label for="featured-image" class="mb-5 inline-block">Featured image</label>
            <input type="file" name="image" id="featured-image">
        </p>
    </div>

</form>