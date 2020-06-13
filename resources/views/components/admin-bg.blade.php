<div class="dashboard-content bg-gray-400 w-5/6 ml-100-16 p-10 pt-0">
    <x-nav-bar logo="0"/>
    @if (isset($title))
        <h3 class="heading pb-4 text-2xl font-bold text-gray-900 border-b border-gray-500 border-opacity-50 mb-12"> {{ $title }}</h3>
    @endif
    
    
    {{ $slot }}
</div>