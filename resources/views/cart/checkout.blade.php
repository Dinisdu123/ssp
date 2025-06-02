<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Checkout your order at Aurora Luxe.">
    <meta name="keywords" content="checkout, Aurora Luxe">
    <title>Checkout - Aurora Luxe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&family=Lora:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    @livewireStyles
    <style>
        body { font-family: 'Lora', serif; }
        h1, h2, h3, h6, .brand { font-family: 'Cinzel', serif; font-weight: 900; }
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
    <nav class="flex flex-wrap items-center justify-between p-4 border-b border-gray-200 bg-white shadow-sm">
        <div class="flex space-x-8 lg:space-x-12">
            <a href="{{ url('/') }}" class="nav-link text-base font-medium text-black hover:text-gray-500 uppercase tracking-wider">Home</a>
            <a href="{{ url('/leather-goods') }}" class="nav-link text-base font-medium text-black hover:text-gray-500 uppercase tracking-wider">Leather Goods</a>
            <a href="{{ url('/fragrances') }}" class="nav-link text-base font-medium text-black hover:text-gray-500 uppercase tracking-wider">Fragrances</a>
            <a href="{{ url('/accessories') }}" class="nav-link text-base font-medium text-black hover:text-gray-500 uppercase tracking-wider">Accessories</a>
        </div>
        <div class="flex items-center space-x-8 lg:space-x-10">
            <span class="brand text-2xl sm:text-3xl font-bold text-black tracking-tight">Aurora Luxe</span>
            <div class="flex space-x-6 items-center">
                <a href="{{ url('/cart') }}">
                    <img src="https://cdn-icons-png.flaticon.com/512/1413/1413908.png" alt="Shopping cart icon" class="w-6 h-6 hover:opacity-80 transition-opacity" />
                </a>
                @auth
                <a href="{{ route('profile.show') }}">
                    <img src="https://cdn-icons-png.flaticon.com/512/6522/6522516.png" alt="User profile icon" class="w-6 h-6 hover:opacity-80 transition-opacity" />
                </a>
                @else
                    <a href="{{ url('/login') }}" class="nav-link text-base font-medium text-black hover:text-gray-500 uppercase tracking-wider">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Checkout Section -->
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-2xl sm:text-3xl font-bold text-black tracking-wider uppercase mb-6">Checkout</h1>
        @livewire('checkout')
    </div>

    <!-- Footer -->
    <footer class="bg-gray-100 text-center lg:text-left py-12">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-10 text-black">
                <div>
                    <h6 class="font-bold text-base mb-4 text-black uppercase tracking-wider">Quick Links</h6>
                    <ul class="text-sm">
                        <li class="mb-3"><a href="{{ url('/') }}" class="hover:text-gray-500 transition-colors">Home</a></li>
                        <li class="mb-3"><a href="{{ url('/new-arrivals') }}" class="hover:text-gray-500 transition-colors">New Arrivals</a></li>
                        <li class="mb-3"><a href="{{ url('/fragrances') }}" class="hover:text-gray-500 transition-colors">Shop</a></li>
                        <li><a href="{{ url('/about') }}" class="hover:text-gray-500 transition-colors">About Us</a></li>
                    </ul>
                </div>
                <div>
                    <h6 class="font-bold text-base mb-4 text-black uppercase tracking-wider">Categories</h6>
                    <ul class="text-sm">
                        <li class="mb-3"><a href="{{ url('/leather-goods') }}" class="hover:text-gray-500 transition-colors">Leather Goods</a></li>
                        <li class="mb-3"><a href="{{ url('/fragrances') }}" class="hover:text-gray-500 transition-colors">Fragrances</a></li>
                        <li><a href="{{ url('/accessories') }}" class="hover:text-gray-500 transition-colors">Accessories</a></li>
                    </ul>
                </div>
                <div>
                    <h6 class="font-bold text-base mb-4 text-black uppercase tracking-wider">Contact Us</h6>
                    <p class="mb-3 text-sm">+94 77 123 4567</p>
                    <p class="mb-3 text-sm">+94 11 234 5678</p>
                    <p class="mb-4 text-sm">auroraluxe@gmail.com</p>
                    <div class="flex space-x-4 justify-center sm:justify-start">
                        <a href="https://www.instagram.com" class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300" aria-label="Follow us on Instagram">
                            <img src="https://i.pinimg.com/474x/1e/d6/e0/1ed6e0a9e69176a5fdb7e090a1046b86.jpg" alt="Instagram logo" class="w-5 h-5">
                        </a>
                        <a href="https://www.facebook.com" class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300" aria-label="Follow us on Facebook">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTQxOMUNq_G-2Tqqcm2l1UYB3WCjRHx6KI2xg&s" alt="Facebook logo" class="w-5 h-5">
                        </a>
                        <a href="https://www.x.com" class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300" aria-label="Follow us on X">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b7/X_logo.jpg/480px-X_logo.jpg" alt="X logo" class="w-5 h-5">
                        </a>
                    </div>
                </div>
            </div>
            <div class="text-center mt-10 text-gray-600 text-sm">
                © 2025 Aurora Luxe. All Rights Reserved.
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>