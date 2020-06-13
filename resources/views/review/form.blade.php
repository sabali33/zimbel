@php
    
@endphp
<form action="{{ $target }}" method="POST" class="flex" enctype="multipart/form-data">
    <div class="w-2/3">
       
            @csrf
            @if($review)
                @method('PUT')
            @endif
            
            <p class="mb-12">
                <label for="full-name" class="mb-5 inline-block"> Full Name </label>
                <input type="text" name="full_name" value="{{ $review ?  $review->full_name : old('full_name') }}" id="full-name" class="w-full px-5 py-3 rounded"/>
                @error('full_name')
                    <div class="error text-red-500">
                        {{ $message }}
                    </div>
                @enderror
                
            </p>
            <p class="mb-12">
                <label for="title" class="mb-5 inline-block"> Profession </label>
                <input type="text" name="title" value="{{ $review ?  $review->title : old('title') }}" id="title" class="w-full px-5 py-3 rounded"/>
                @error('title')
                    <div class="error text-red-500">
                        {{ $message }}
                    </div>
                @enderror
                
            </p>
            <div class="mb-12 relative">
                <label for="product-id" class="mb-5 inline-block">Product</label>
                <select name="product_id" id="product-id" class="w-full py-3 px-5 pr-8 rounded leading-tight appearance-none">
                    @if ($products->count() > 0)
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}"> {{ $product->title }}</option>
                        @endforeach
                    @endif
                    
                </select>
                <div class="pointer-events-none absolute top-3/5 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
            </div>
            <p class="mb-12">
                <label for="remark" class="mb-5 inline-block">Remark</label>
                <textarea name="remark" id="remark" cols="30" rows="10" class="w-full px-5 py-3 rounded" value=""> {{ $review ? $review->remark : old('remark') }} </textarea>
                @error('remark')
                    <div class="error text-red-500">
                        {{ $message }}
                    </div>
                @enderror
            </p>
            <p class="mb-12">
                <label for="rate" class="mb-5 inline-block">Rate</label>
                <input name="rate" type="number" value="{{  $review ? $review->rate : old('rate') }}" id="rate" class="w-full px-5 py-3 rounded" min="0" max="5" step="0.1">
                @error('rate')
                    <div class="error text-red-500">
                        {{ $message }}
                    </div>
                @enderror
                <div class="user-rate w-1/2 h-12 bg-gray-500"></div>
            </p>
            
            <p class="mb-12">
                
                <input name="ip_address" type="hidden" value="{{  $ip }}"   id="ip-address" class="w-full px-5 py-3 rounded">
                @error('ip_address')
                    <div class="error text-red-500">
                        {{ $message }}
                    </div>
                @enderror
            </p>
            <p class="mb-12">
                <button class="capitalize px-4 py-2 bg-blue-500 rounded hover:shadow-md transition ease-in duration-200">
                    @if($review)
                        update
                    @else
                        create
                    @endif
                </button>
            </p>
        
        
    </div>
    
</form>