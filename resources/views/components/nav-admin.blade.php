@php
    $current_route_name = Route::currentRouteName();
    $active = function($route) use($current_route_name){
        return Str::startsWith($current_route_name, $route ) ? 'text-blue-500' : '';
    }
    
@endphp
<nav class="w-1/6 bg-gray-900 p-5 fixed h-screen">
    <div class="title mb-10">
        <a href="/">
            <img src="{{ url('images/logo.jpg')}}" alt="Zimbel Digits" class="w-32">
        </a>
        
    </div>
    <ul>
        
        
        @if (Gate::allows('is_admin'))
            <li class="py-3 text-white hover:text-blue-500 transition ease-out duration-200 {{ $active('products')}} ">
                <a href="/admin/products" class="hover:text-blue-500 transition ease-out duration-200 ">
                    <i class="icon icon-power-cord"></i>
                    Products
                </a>
            </li>
            <li class="py-3 text-white hover:text-blue-500 transition ease-out duration-200 {{ $active('features')}}">
                <a href="/admin/features" class="hover:text-blue-500 transition ease-out duration-200">
                    <i class=" icon icon-featured_play_list"></i>
                    Features
                </a>
            </li>
            <li class="py-3 text-white hover:text-blue-500 transition ease-out duration-200 {{ $active('customers')}}">
                <a href="/admin/customers" class="">
                    <i class="icon icon-users"></i>
                    Customers
                </a>
            </li>
            <li class="py-3 text-white hover:text-blue-500 transition ease-out duration-200 {{ $active('pages')}}">
                <a href="/admin/pages" class="hover:text-blue-500 transition ease-out duration-200">
                    <i class="icon icon-files-empty"></i>
                    Pages 
                </a>
            </li>
        @endif
        
        
        <li class="py-3 text-white hover:text-blue-500 transition ease-out duration-200 {{ $active('licenses')}}">
            <a href="/admin/licenses" class="hover:text-blue-500 transition ease-out duration-200">
                <i class="icon icon-files-empty"></i>
                Licenses
            </a>
        </li>
        <li class="py-3 text-white hover:text-blue-500 transition ease-out duration-200 {{ $active('reviews')}}">
            <a href="/admin/reviews" class="hover:text-blue-500 transition ease-out duration-200">
                <i class="icon icon-messages"></i>
                Reviews
            </a>
        </li>
        <li class="py-3 text-white hover:text-blue-500 transition ease-out duration-200 {{ $active('schedules')}}">
            <a href="/admin/schedules" class="hover:text-blue-500 transition ease-out duration-200">
                <i class="icon icon-schedule"></i>
                Schedules
            </a>
        </li>
        <li class="py-3 text-white hover:text-blue-500 transition ease-out duration-200 {{ $active('times')}}">
            <a href="/admin/times" class="hover:text-blue-500 transition ease-out duration-200">
                <i class="icon icon-schedule"></i>
                Times
            </a>
        </li>
        <li class="py-3 text-white hover:text-blue-500 transition ease-out duration-200 {{ $active('media')}}">
            <a href="/admin/media" class="hover:text-blue-500 transition ease-out duration-200">
                <i class="icon icon-schedule"></i>
                Media
            </a>
        </li>
    </ul>
</nav>
