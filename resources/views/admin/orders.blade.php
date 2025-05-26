<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Orders - {{ config('app.name', 'Laravel') }}</title>
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
            <h2 class="font-semibold text-xl text-gray-800 font-cinzel">Orders</h2>

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

        <!-- Orders List -->
        <h3 class="text-lg font-semibold text-black font-cinzel uppercase tracking-wider mb-4">All Orders</h3>
        @if ($orders->isEmpty())
            <p class="text-gray-600 font-lora">No orders found.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full table-auto bg-white rounded-md shadow-md">
                    <thead>
                        <tr class="border-b">
                            <th class="py-3 px-4 text-left font-cinzel text-sm text-black uppercase">Order ID</th>
                            <th class="py-3 px-4 text-left font-cinzel text-sm text-black uppercase">User</th>
                            <th class="py-3 px-4 text-left font-cinzel text-sm text-black uppercase">Ordered Date</th>
                            <th class="py-3 px-4 text-left font-cinzel text-sm text-black uppercase">Delivery Address</th>
                            <th class="py-3 px-4 text-left font-cinzel text-sm text-black uppercase">Status</th>
                            <th class="py-3 px-4 text-left font-cinzel text-sm text-black uppercase">Total Price (LKR)</th>
                            <th class="py-3 px-4 text-left font-cinzel text-sm text-black uppercase">Items</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="border-b">
                                <td class="py-3 px-4 font-lora text-sm">{{ e($order->_id) }}</td>
                                <td class="py-3 px-4 font-lora text-sm">{{ e($order->user->name ?? 'N/A') }}</td>
                                <td class="py-3 px-4 font-lora text-sm">{{ $order->ordered_date ? $order->ordered_date->format('Y-m-d H:i') : 'N/A' }}</td>
                                <td class="py-3 px-4 font-lora text-sm">{{ e($order->delivery_address ?? 'N/A') }}</td>
                                <td class="py-3 px-4 font-lora text-sm">
                                    <form action="{{ route('admin.order.update-status', $order->_id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="order_status" onchange="this.form.submit()" class="border p-1 rounded-md font-lora text-sm">
                                            <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="shipped" {{ $order->order_status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="delivered" {{ $order->order_status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="py-3 px-4 font-lora text-sm">{{ number_format($order->total_price ?? 0, 2) }}</td>
                                <td class="py-3 px-4 font-lora text-sm">
                                    <ul class="list-disc pl-4">
                                        @foreach ($order->items as $item)
                                            <li>{{ e($item->product->name ?? 'N/A') }} (Qty: {{ $item->quantity }})</li>
                                        @endforeach
                                    </ul>
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