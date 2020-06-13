@php
    $product_images = $product && $product->hasMedia('featured') ? $product->getMedia('featured') : null;
    $media_ids = $product_images ? $product_images->implode('id', ',') : '';
    $attachment_urls = [];
    if($product_images){
        $attachment_urls = $product_images->mapWithKeys(function($media){
            return [ $media->id => "/{$media->disk}/{$media->directory}/{$media->filename}.{$media->extension}"];
        });
    }
    
@endphp
<form action="{{ $target }}" method="POST" class="flex" enctype="multipart/form-data">
    <div class="w-2/3">
        
            @csrf
            @if($product)
                @method('PUT')
            @endif
            
            <p class="mb-12">
                <label for="title" class="mb-5 inline-block"> Title </label>
                <input type="text" name="title" value="{{ $product ?  $product->title : old('title') }}" id="title" class="w-full px-5 py-3 rounded"/>
                @error('title')
                    <div class="error text-red-500">
                        {{ $message }}
                    </div>
                @enderror
                
            </p>
            <p class="mb-12">
                <label for="description" class="mb-5 inline-block">Description</label>
                <textarea name="description" id="description" cols="30" rows="10" class="w-full px-5 py-3 rounded" value=""> {{ $product ? $product->description : old('description') }} </textarea>
                @error('description')
                    <div class="error text-red-500">
                        {{ $message }}
                    </div>
                @enderror
            </p>
            <p class="mb-12">
                <label for="link" class="mb-5 inline-block">Link</label>
                <input name="link" type="url" value="{{  $product ? $product->link : old('link') }}" id="link" class="w-full px-5 py-3 rounded">
                @error('link')
                    <div class="error text-red-500">
                        {{ $message }}
                    </div>
                @enderror
            </p>
            <p class="mb-12">
                <label for="link" class="mb-5 inline-block">Price</label>
                <input name="price" type="number" value="{{  $product ? $product->price : old('price') }}" id="link" class="w-full px-5 py-3 rounded" min="1" step="0.1">
                @error('price')
                    <div class="error text-red-500">
                        {{ $message }}
                    </div>
                @enderror
            </p>
            <p class="mb-12">
                <button class="capitalize px-4 py-2 bg-blue-500 rounded hover:shadow-md transition ease-in duration-200">
                    @if($product)
                        update
                    @else
                        create
                    @endif
                </button>
            </p>
        <p>
            <input type="hidden" name="user_id" value="{{ Auth::user()->id}}">
            @error('user_id')
                    <div class="error text-red-500">
                        {{ $message }}
                    </div>
                @enderror
        </p>
        
    </div>
    <div class="w-1/3 p-6">
        <div class="mb-12">
            {{-- <label for="featured-image" class="mb-5 inline-block">Upload Image</label>
            <input type="file" name="image" id="featured-image"> --}}
            <h3 class="mb-5 font-bold text-xl">Attachments</h3>
            <input type="hidden" name="attachment_ids" id="featured-image" value="{{ $media_ids }}">
            <div class="div preview-featured">
                @foreach ($attachment_urls as $id => $media_url)
                    <span class="selected w-1/2 mb-5 inline-block relative cursor-pointer" data-mediaid="{{ $id }}">
                        <img src="{{ $media_url }}" alt="Featured Image">
                        <span class="absolute icon-times text-red-500 text-xl hover:bg-gray-500 rounded" data-mediaid="{{ $id }}"></span>
                    </span>
                @endforeach
            </div>
            <span class="add-media cursor-pointer w-full h-32 bg-gray-500 text-white p-3" data-attach="1">Attach Image </span>
            
        </div>
        <p class="mb-12">
            <div class="mb-5 inline-block">Feature List</div>
            <ul id="feature-list" class="w-full h-12 py-3 rounded">
                @if($features)
                    @foreach( $features as $feature )
                    <li class="mb-4">
                        @php
                            $product_feature_ids = isset($product->features) ? $product->features->pluck('id')->toArray() : [];
                            $old = old('feature') ? in_array($feature->id, old('features')) : null
                        @endphp
                        <input type="checkbox" name="features[]" id="feature-{{ $feature->id }}" value="{{ $feature->id }}" class="mr-3" {{ in_array($feature->id, $product_feature_ids) || $old ? 'checked' : ''}}>
                        <label for="feature-{{ $feature->id }}"  > {{ $feature->name }}</label>
                    </li>
                        
                    @endforeach
                @endif
            </ul>
        </p>
    </div>
</form>
<div class="media-modal-box fixed inset-0 bg-gray-500 bg-opacity-50 hidden"></div>