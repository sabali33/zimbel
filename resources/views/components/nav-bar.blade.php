<div>
    <nav class="bg-white-900  mb-8 py-6">
        <div class="md:px-0">
           
            <div class="flex items-center align-content-between justify-between">
                @if($logo)
                    <div class="mr-6 md:flex md:shadow ">
                        <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-900 no-underline">
                            {{-- {{ config('app.name', 'Zimbel') }} --}}
                        <img src="{{ url('images/logo.jpg')}}" alt="Zimbel Digits" class="w-20 sm:mx-auto">
                        </a>
                    </div>
                @endif
                <x-frontend-nav class="shadow h-12 items-center rounded hidden md:flex">
                    <li>
                        @guest
                        <a class="no-underline hover:underline text-gray-500 text-sm p-3" href="{{ route('login') }}">{{ __('Login') }}</a>
                        
                    @else
                        <span class="text-gray-300 text-sm pr-4">{{ Auth::user()->name }}</span>

                        <a href="{{ route('logout') }}"
                           class="no-underline hover:underline text-gray-900 text-sm p-3"
                           onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            {{ csrf_field() }}
                        </form>
                    @endguest
                    </li>
                </x-frontend-nav>
                <div class="mobile-nav md:hidden">
                    <span class="icon icon-menu">
                    </span>
                </div>
                
            </div>
        </div>
    </nav>
</div>