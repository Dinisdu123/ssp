<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Explore Aurora Luxe's exquisite collection of luxury jewellery and footwear, designed for elegance and sophistication.">
    <meta name="keywords" content="luxury jewellery, luxury footwear, accessories, Aurora Luxe">
    <title>Aurora Luxe - Accessories</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts for Luxury Typography -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&family=Lora:ital,wght@0,400;0,700;1,400&display=swap" as="style">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&family=Lora:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Lora', serif;
        }
        h1, h2, h3, h6, .brand {
            font-family: 'Cinzel', serif;
            font-weight: 900;
        }
        .nav-link {
            position: relative;
            transition: color 0.4s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 1px;
            bottom: -2px;
            left: 0;
            background-color: #D4AF37; /* Gold accent */
            transition: width 0.4s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }
        .product-card {
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }
        .fade-in {
            opacity: 0;
            animation: fadeIn 1.2s ease forwards;
        }
        @keyframes fadeIn {
            to { opacity: 1; }
        }
        .social-icon {
            transition: background-color 0.4s ease, transform 0.4s ease;
        }
        .social-icon:hover {
            transform: scale(1.1);
        }
        .button-pulse {
            background-color: #D4AF37;
            color: #000000;
            transition: all 0.4s ease;
        }
        .button-pulse:hover {
            background-color: #b8972e;
            transform: scale(1.03);
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.25);
        }
    </style>
</head>
<body class="bg-white text-black">
    <!-- Navbar -->
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

    <div class="container mx-auto px-6 py-12">
        <!-- Jewellery Display -->
        <div class="mb-16">
            <h2 class="text-2xl font-bold text-center text-black tracking-wider uppercase mb-6">Jewellery</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse ($jewellery as $product)
                    <div class="bg-white rounded-lg shadow-md p-4 product-card">
                        <a href="{{ url('product/' . $product->_id) }}">
                            <img src="{{ e($product->image_url) }}" alt="{{ e($product->name) }}" class="w-full h-48 object-cover rounded-md fade-in" loading="lazy">
                        </a>
                        <h3 class="text-base font-medium text-black uppercase tracking-wide mt-4">{{ $product->name }}</h3>
                        <p class="text-gray-700 text-sm mt-2">LKR {{ number_format($product->price, 2) }}</p>
                        
                    </div>
                @empty
                    <p class="text-gray-600 text-base col-span-full text-center">No products found in this category.</p>
                @endforelse
            </div>
        </div>

        <!-- Footwear Display -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-center text-black tracking-wider uppercase mb-6">Footwear</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse ($footwear as $product)
                    <div class="bg-white rounded-lg shadow-md p-4 product-card">
                        <a href="{{ url('product/' . $product->_id) }}">
                            <img src="{{ e($product->image_url) }}" alt="{{ e($product->name) }}" class="w-full h-48 object-cover rounded-md fade-in" loading="lazy">
                        </a>
                        <h3 class="text-base font-medium text-black uppercase tracking-wide mt-4">{{ $product->name }}</h3>
                        <p class="text-gray-700 text-sm mt-2">LKR {{ number_format($product->price, 2) }}</p>
                        
                    </div>
                @empty
                    <p class="text-gray-600 text-base col-span-full text-center">No products found in this category.</p>
                @endforelse
            </div>
        </div>
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
                        <a href="https://www.instagram.com" class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center social-icon hover:bg-gray-300" aria-label="Follow us on Instagram">
                            <img src="https://i.pinimg.com/474x/1e/d6/e0/1ed6e0a9e69176a5fdb7e090a1046b86.jpg" alt="Instagram logo" class="w-5 h-5">
                        </a>
                        <a href="https://www.facebook.com" class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center social-icon hover:bg-gray-300" aria-label="Follow us on Facebook">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTQxOMUNq_G-2Tqqcm2l1UYB3WCjRHx6KI2xg&s" alt="Facebook logo" class="w-5 h-5">
                        </a>
                        <a href="https://www.x.com" class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center social-icon hover:bg-gray-300" aria-label="Follow us on X">
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
</body>
</html>