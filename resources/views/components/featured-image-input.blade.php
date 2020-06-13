<h3 class="mb-5 font-bold text-xl">Attachments</h3>
<input type="hidden" name="attachment_ids" id="featured-image" value="{{ $media_ids }}">
<div class="div preview-featured">
    @foreach ($attachment_urls as $media_url)
        <a href="{{ $media_url}}" class="w-1/2 mb-5 inline-block">
            <img src="{{ $media_url }}" alt="Featured Image">
        </a>
    @endforeach
</div>
<span class="add-media cursor-pointer w-full h-32 bg-gray-500 text-white p-3" data-attach="1">Attach Image </span>