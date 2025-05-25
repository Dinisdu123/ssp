<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight font-cinzel">Orders</h2>
    </x-slot>

    <div class="container mx-auto px-4 py-12">
        <!-- Navigation Buttons -->
        <div class="flex space-x-4 mb-8">
            <a href="{{ route('admin.dashboard') }}" class="button-pulse py-2 px-4 rounded-md font-cinzel text-black uppercase tracking-wider">Dashboard</a>
            <a href="{{ route('admin.orders') }}" class="button-pulse py-2 px-4 rounded-md font-cinzel text-black uppercase tracking-wider">Orders</a>
            <a href="{{ route('admin.add-item') }}" class="button-pulse py-2 px-4 rounded-md font-cinzel text-black uppercase tracking-wider">Add Item</a>
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
                                <td class="py-3 px-4 font-lora text-sm">{{ $order->ordered_date->format('Y-m-d H:i') }}</td>
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
    </div>
</x-app-layout>