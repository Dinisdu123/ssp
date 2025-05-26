<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Add Product - {{ config('app.name', 'Laravel') }}</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Custom Fonts (Cinzel and Lora) -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Lora&display=swap" rel="stylesheet">
    <style>
        .button-pulse {
            transition: all 0.3s ease-in-out;
        }
        .button-pulse:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .profile-menu {
            transition: all 0.2s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <!-- Page Heading -->
            <h2 class="font-semibold text-xl text-gray-800 font-cinzel">Add Product</h2>

            <!-- Profile Icon Button -->
            @auth
                <div class="relative">
                    <button class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none" onclick="document.getElementById('profile-menu').classList.toggle('hidden')">
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="profile-menu" class="hidden profile-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 font-lora">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 font-lora">Log Out</button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </header>

    <main class="container mx-auto px-4 py-12">
        <!-- Navigation Buttons -->
        <div class="flex space-x-4 mb-8">
            <a href="{{ route('admin.dashboard') }}" class="button-pulse py-2 px-4 bg-gray-200 rounded-md font-cinzel text-black uppercase tracking-wider hover:bg-gray-300">Dashboard</a>
            <a href="{{ route('admin.orders') }}" class="button-pulse py-2 px-4 bg-gray-200 rounded-md font-cinzel text-black uppercase tracking-wider hover:bg-gray-300">Orders</a>
            <a href="{{ route('admin.add-item') }}" class="button-pulse py-2 px-4 bg-gray-200 rounded-md font-cinzel text-black uppercase tracking-wider hover:bg-gray-300">Add Item</a>
        </div>

        <!-- Add Product Form -->
        <h3 class="text-lg font-semibold text-black font-cinzel uppercase tracking-wider mb-4">Add New Product</h3>
        <div class="bg-white p-6 rounded-md shadow-md max-w-lg">
            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-md mb-4 font-lora">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 text-red-700 p-4 rounded-md mb-4 font-lora">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('admin.product.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-cinzel text-black">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full border border-gray-300 p-2 rounded-md font-lora focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                    @error('name')
                        <p class="text-red-600 text-sm font-lora mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-cinzel text-black">Description</label>
                    <textarea name="description" id="description" class="w-full border border-gray-300 p-2 rounded-md font-lora focus:outline-none focus:ring-2 focus:ring-gray-500" required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-600 text-sm font-lora mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="image_url" class="block text-sm font-cinzel text-black">Image URL</label>
                    <input type="text" name="image_url" id="image_url" value="{{ old('image_url') }}" class="w-full border border-gray-300 p-2 rounded-md font-lora focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                    @error('image_url')
                        <p class="text-red-600 text-sm font-lora mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="price" class="block text-sm font-cinzel text-black">Price (LKR)</label>
                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" class="w-full border border-gray-300 p-2 rounded-md font-lora focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                    @error('price')
                        <p class="text-red-600 text-sm font-lora mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="stock_quantity" class="block text-sm font-cinzel text-black">Stock Quantity</label>
                    <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity') }}" class="w-full border border-gray-300 p-2 rounded-md font-lora focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                    @error('stock_quantity')
                        <p class="text-red-600 text-sm font-lora mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="category" class="block text-sm font-cinzel text-black">Category</label>
                    <select name="category" id="category" class="w-full border border-gray-300 p-2 rounded-md font-lora focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                        <option value="" disabled {{ old('category') ? '' : 'selected' }}>Select Category</option>
                        <option value="leather-goods" {{ old('category') === 'leather-goods' ? 'selected' : '' }}>Leather Goods</option>
                        <option value="fragrance" {{ old('category') === 'fragrance' ? 'selected' : '' }}>Fragrance</option>
                        <option value="accessories" {{ old('category') === 'accessories' ? 'selected' : '' }}>Accessories</option>
                    </select>
                    @error('category')
                        <p class="text-red-600 text-sm font-lora mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="sub_category" class="block text-sm font-cinzel text-black">Sub Category</label>
                    <select name="sub_category" id="sub_category" class="w-full border border-gray-300 p-2 rounded-md font-lora focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                        <option value="" disabled {{ old('sub_category') ? '' : 'selected' }}>Select Sub Category</option>
                        <option value="shoulder bags" {{ old('sub_category') === 'shoulder bags' ? 'selected' : '' }}>Shoulder Bags</option>
                        <option value="minibags" {{ old('sub_category') === 'minibags' ? 'selected' : '' }}>Minibags</option>
                        <option value="backpacks" {{ old('sub_category') === 'backpacks' ? 'selected' : '' }}>Backpacks</option>
                        <option value="wallets" {{ old('sub_category') === 'wallets' ? 'selected' : '' }}>Wallets</option>
                        <option value="mens" {{ old('sub_category') === 'mens' ? 'selected' : '' }}>Mens</option>
                        <option value="ladies" {{ old('sub_category') === 'ladies' ? 'selected' : '' }}>Ladies</option>
                        <option value="jewellery" {{ old('sub_category') === 'jewellery' ? 'selected' : '' }}>Jewellery</option>
                        <option value="footwear" {{ old('sub_category') === 'footwear' ? 'selected' : '' }}>Footwear</option>
                    </select>
                    @error('sub_category')
                        <p class="text-red-600 text-sm font-lora mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="submit" class="button-pulse py-2 px-4 bg-gray-200 rounded-md font-lora text-black hover:bg-gray-300">Add Product</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>