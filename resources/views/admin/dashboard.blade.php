<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - {{ config('app.name', 'Laravel') }}</title>
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
            <h2 class="font-semibold text-xl text-gray-800 font-cinzel">Admin Dashboard</h2>

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

        <!-- Product List -->
        <h3 class="text-lg font-semibold text-black font-cinzel uppercase tracking-wider mb-4">All Products</h3>
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md font-lora">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md font-lora">
                {{ session('error') }}
            </div>
        @endif
        @if ($products->isEmpty())
            <p class="text-gray-600 font-lora">No products found.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full table-auto bg-white rounded-md shadow-md">
                    <thead>
                        <tr class="border-b">
                            <th class="py-3 px-4 text-left font-cinzel text-sm text-black uppercase">Name</th>
                            <th class="py-3 px-4 text-left font-cinzel text-sm text-black uppercase">Description</th>
                            <th class="py-3 px-4 text-left font-cinzel text-sm text-black uppercase">Image</th>
                            <th class="py-3 px-4 text-left font-cinzel text-sm text-black uppercase">Price (LKR)</th>
                            <th class="py-3 px-4 text-left font-cinzel text-sm text-black uppercase">Stock</th>
                            <th class="py-3 px-4 text-left font-cinzel text-sm text-black uppercase">Category</th>
                            <th class="py-3 px-4 text-left font-cinzel text-sm text-black uppercase">Sub Category</th>
                            <th class="py-3 px-4 text-left font-cinzel text-sm text-black uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr class="border-b">
                                <td class="py-3 px-4 font-lora text-sm">{{ e($product->name ?? 'N/A') }}</td>
                                <td class="py-3 px-4 font-lora text-sm">{{ e(\Illuminate\Support\Str::limit($product->description ?? 'N/A', 50)) }}</td>
                                <td class="py-3 px-4">
                                    <img src="{{ e($product->image_url ?? 'https://via.placeholder.com/64') }}" alt="{{ e($product->name ?? 'Product Image') }}" class="w-16 h-16 object-cover rounded">
                                </td>
                                <td class="py-3 px-4 font-lora text-sm">{{ number_format($product->price ?? 0, 2) }}</td>
                                <td class="py-3 px-4 font-lora text-sm">{{ $product->stock_quantity ?? 0 }}</td>
                                <td class="py-3 px-4 font-lora text-sm">{{ e($product->category ?? 'N/A') }}</td>
                                <td class="py-3 px-4 font-lora text-sm">{{ e($product->sub_category ?? 'N/A') }}</td>
                                <td class="py-3 px-4 flex space-x-2">
                                    <form action="{{ route('admin.product.delete', $product->_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 text-white py-1 px-3 rounded-md hover:bg-red-700 font-lora text-sm">Remove</button>
                                    </form>
                                    <a href="{{ route('admin.product.edit', $product->_id) }}" class="bg-blue-600 text-white py-1 px-3 rounded-md hover:bg-blue-700 font-lora text-sm">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </main>
</body>
</html>