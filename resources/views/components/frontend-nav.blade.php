<ul {{ $attributes->merge(['class' => 'nav-list flex w-full justify-end pr-10 text-gray-900']) }}>
    @guest
    <li class="mr-6">
        <a href="/" class="hover:text-blue-500 transition ease-out duration-200">Home</a>   
    </li>
    <li class="mr-6"> 
        <a href="/pages/about" class="hover:text-blue-500 transition ease-out duration-200">About</a> 
    </li>
    <li class="mr-6">
        <a href="/pages/docs" class="hover:text-blue-500 transition ease-out duration-200">Docs</a> 
    </li>
    <li class="mr-6">
        <a href="/pages/contact" class="hover:text-blue-500 transition ease-out duration-200">Contact</a> 
    </li>
    <li class="mr-6">
        <a href="/reviews" class="hover:text-blue-500 transition ease-out duration-200">See Who is smiling</a> 
    </li>
    @endguest
    
    {{ $slot }}
</ul>