@php
    $attachments = $feature && $feature->getMedia('featured')->count() ? $feature->getMedia('featured') : null;
    $attachment_urls = [];
    
    if($attachments){
        $attachment_urls = $attachments->map(function($attachment){
            return "/{$attachment->disk}/{$attachment->directory}/{$attachment->filename}.{$attachment->extension}";
        });
    }
    $media_ids = $attachments ? $attachments->implode('id', ',') : '';
@endphp
<form action="{{ $target }}" method="POST" class="flex">
    @csrf
    @if($feature)
        @method('PUT')
    @endif
    <div class="w-2/3">
        <p class="mb-12">
            <label for="name" class="mb-5 inline-block"> Name </label>
            <input type="text" name="name" value="{{ $feature ?  $feature->name : old('name') }}" id="name" class="w-full px-5 py-3 rounded"/>
            @error('name')
                <div class="error text-red-500">
                    {{ $message }}
                </div>
            @enderror
            
        </p>
        <p class="mb-12">
            <label for="alias" class="mb-5 inline-block">Alias</label>
            <textarea name="alias" id="alias" cols="30" rows="10" class="w-full px-5 py-3 rounded" value=""> {{ $feature ? $feature->alias : old('alias') }} </textarea>
            @error('alias')
                <div class="error text-red-500">
                    {{ $message }}
                </div>
            @enderror
        </p>
        <p class="mb-12">
            <label for="product-id" class="mb-5 inline-block">Set product </label>
            <select name="product_id" id="product-id" class="w-full h-12 py-3 rounded">
                @foreach($products as $product)
                @php
                    $feature_product = null;
                    if(isset($feature->product)){
                        $feature_product = $feature->product->id;
                    }
                @endphp
                    
                    <option value="{{ $product->id }}" {{ $product->id == $feature_product ? 'selected' : '' }}> {{ $product->title }} </option>
                @endforeach
            </select>
        </p>
        <p class="mb-12">
            <button class="capitalize px-4 py-2 bg-blue-500 rounded hover:shadow-md transition ease-in duration-200">
                @if($feature)
                    update
                @else
                    create
                @endif
            </button>
        </p>
        <p>
            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
        </p>
    </div>
    <div class="w-1/3 ml-10">
        @include('components.featured-image-input', compact('attachment_urls'))
    </div>
    
</form>
<div class="media-modal-box fixed inset-0 bg-gray-500 bg-opacity-50 hidden"></div>