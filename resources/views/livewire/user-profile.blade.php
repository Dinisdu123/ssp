<div>
    @if (session()->has('success'))
        <div class="text-green-600 mb-4">{{ session('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="text-red-600 mb-4">{{ session('error') }}</div>
    @endif

    <h1 class="text-2xl sm:text-3xl font-bold text-black tracking-wider uppercase mb-6">My Profile</h1>

    <div class="border p-4 rounded-md bg-gray-50 mb-8">
        <h2 class="text-xl font-semibold mb-4">User Information</h2>
        <p><strong>Name:</strong> {{ e($user->name) }}</p>
        <p><strong>Email:</strong> {{ e($user->email) }}</p>
        <button wire:click="logout" class="bg-red-600 text-white py-2 px-6 rounded-md hover:bg-red-800 button-pulse mt-4">Logout</button>
    </div>

    <h2 class="text-xl sm:text-2xl font-semibold mb-4">Order History</h2>
    @if ($orders->isEmpty())
        <p class="text-gray-600">You have no orders yet.</p>
    @else
        <div class="space-y-4">
            @foreach ($orders as $order)
                <div class="border p-4 rounded-md bg-gray-50">
                    <h3 class="font-semibold">Order #{{ $order->_id }}</h3>
                    <p><strong>Date:</strong> {{ $order->ordered_date->format('Y-m-d H:i:s') }}</p>
                    <p><strong>Status:</strong> {{ $order->order_status }}</p>
                    <p><strong>Total:</strong> LKR {{ number_format($order->total_price, 2) }}</p>
                    <p><strong>Delivery Address:</strong> {{ e($order->delivery_address) }}</p>
                    <h4 class="font-semibold mt-2">Items:</h4>
                    @foreach ($order->items as $item)
                        <div class="flex items-center space-x-4 mt-2">
                            <img src="{{ asset($item->product->image ?? 'images/placeholder.jpg') }}" alt="{{ e($item->product->name) }}" class="w-12 h-12 object-cover rounded">
                            <div>
                                <p>{{ e($item->product->name) }}</p>
                                <p>Quantity: {{ $item->quantity }}</p>
                                <p>Unit Price: LKR {{ number_format($item->unit_price, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endif
</div>