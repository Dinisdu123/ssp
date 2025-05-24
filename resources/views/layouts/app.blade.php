<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Aurora Luxe') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&family=Lora:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    <style>
        body { font-family: 'Lora', serif; }
        h1, h2, .brand { font-family: 'Cinzel', serif; font-weight: 900; }
        .nav-link { position: relative; transition: color 0.4s ease; }
        .nav-link::after {
            content: ''; position: absolute; width: 0; height: 1px; bottom: -2px; left: 0;
            background-color: #D4AF37; transition: width 0.4s ease;
        }
        .nav-link:hover::after { width: 100%; }
        .button-pulse {
            background-color: #D4AF37; color: #000000; transition: all 0.4s ease;
        }
        .button-pulse:hover {
            background-color: #b8972e; transform: scale(1.03); box-shadow: 0 0 12px rgba(0, 0, 0, 0.25);
        }
    </style>
</head>
<body class="bg-white text-black">
    <div x-data="{ open: false }">
        <!-- Navigation Bar -->
        <nav class="flex flex-wrap items-center justify-between p-4 border-b border-gray-200 bg-white shadow-sm">
            <div class="flex space-x-8 lg:space-x-12">
                <a href="{{ route('home') }}" class="nav-link text-base font-medium text-black hover:text-gray-500 uppercase tracking-wider">Home</a>
                <a href="{{ route('leather-goods') }}" class="nav-link text-base font-medium text-black hover:text-gray-500 uppercase tracking-wider">Leather Goods</a>
                <a href="{{ route('fragrances') }}" class="nav-link text-base font-medium text-black hover:text-gray-500 uppercase tracking-wider">Fragrances</a>
                <a href="{{ route('accessories') }}" class="nav-link text-base font-medium text-black hover:text-gray-500 uppercase tracking-wider">Accessories</a>
            </div>
            <div class="flex items-center space-x-8 lg:space-x-10">
                <span class="brand text-2xl sm:text-3xl font-bold text-black tracking-tight">Aurora Luxe</span>
                <div class="flex space-x-6 items-center">
                    <a href="{{ route('cart.index') }}">
                        <img src="https://cdn-icons-png.flaticon.com/512/1413/1413908.png" alt="Shopping cart icon" class="w-6 h-6 hover:opacity-80 transition-opacity" />
                    </a>
                    @auth
                        <div class="relative" x-data="{ dropdown: false }">
                            <button @click="dropdown = !dropdown" class="flex items-center">
                                <img src="{{ Auth::user()->profile_photo_url ?? asset('images/profile.png') ?? 'https://cdn-icons-png.flaticon.com/512/149/149071.png' }}" alt="User profile icon" class="w-6 h-6 rounded-full hover:opacity-80 transition-opacity" />
                            </button>
                            <div x-show="dropdown" @click.away="dropdown = false" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-10">
                                <div class="block px-4 py-2 text-xs text-gray-400 font-cinzel">
                                    {{ __('Manage Account') }}
                                </div>
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-black hover:bg-gray-100 font-lora">{{ __('Profile') }}</a>
                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <a href="{{ route('api-tokens.index') }}" class="block px-4 py-2 text-sm text-black hover:bg-gray-100 font-lora">{{ __('API Tokens') }}</a>
                                @endif
                                <div class="border-t border-gray-200"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-black hover:bg-gray-100 font-lora">{{ __('Log Out') }}</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ url('/login') }}" class="nav-link text-base font-medium text-black hover:text-gray-500 uppercase tracking-wider">Login</a>
                    @endauth
                </div>
                <!-- Hamburger for Mobile -->
                <div class="sm:hidden">
                    <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                        <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Responsive Mobile Menu -->
        <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden bg-white border-b border-gray-200">
            <div class="pt-2 pb-3 space-y-1 px-4">
                <a href="{{ route('home') }}" class="block nav-link text-base font-medium text-black hover:text-gray-500 uppercase tracking-wider py-2">Home</a>
                <a href="{{ route('leather-goods') }}" class="block nav-link text-base font-medium text-black hover:text-gray-500 uppercase tracking-wider py-2">Leather Goods</a>
                <a href="{{ route('fragrances') }}" class="block nav-link text-base font-medium text-black hover:text-gray-500 uppercase tracking-wider py-2">Fragrances</a>
                <a href="{{ route('accessories') }}" class="block nav-link text-base font-medium text-black hover:text-gray-500 uppercase tracking-wider py-2">Accessories</a>
                <a href="{{ route('cart.index') }}" class="block nav-link text-base font-medium text-black hover:text-gray-500 uppercase tracking-wider py-2">Cart</a>
                @auth
                    <a href="{{ route('profile.show') }}" class="block nav-link text-base font-medium text-black hover:text-gray-500 uppercase tracking-wider py-2">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block nav-link text-base font-medium text-black hover:text-gray-500 uppercase tracking-wider py-2">Log Out</button>
                    </form>
                @else
                    <a href="{{ url('/login') }}" class="block nav-link text-base font-medium text-black hover:text-gray-500 uppercase tracking-wider py-2">Login</a>
                @endauth
            </div>
        </div>

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')
    @livewireScripts
</body>
</html>