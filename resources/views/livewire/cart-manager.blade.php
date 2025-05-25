<div>
    @if (session()->has('success'))
        <div class="text-green-600 mb-4">{{ session('success') }}</div>
    @endif

    @if ($cartItems->isEmpty())
        <p class="text-gray-600 text-center">Your cart is empty.</p>
    @else
        <div class="space-y-4">
            @foreach ($cartItems as $item)
                <div class="flex flex-col sm:flex-row items-center justify-between border p-4 rounded-md bg-gray-50">
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset($item->product->image_url ?? $item->product->image_url) }}" alt="{{ e($item->product->name) }}" class="w-20 h-20 object-cover rounded">
                        <div>
                            <h3 class="font-semibold">{{ e($item->product->name) }}</h3>
                            <p class="text-gray-600">LKR {{ number_format($item->product->price, 2) }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 mt-4 sm:mt-0">
                        <input type="number" wire:model.lazy="cartItems.{{ $loop->index }}.quantity" wire:change="updateQuantity('{{ $item->_id }}', $event.target.value)" min="1" class="border p-2 rounded-md w-20 text-center">
                        <p class="text-gray-600">Total: LKR {{ number_format($item->total_price, 2) }}</p>
                        <button wire:click="removeItem('{{ $item->_id }}')" class="text-red-600 hover:text-red-800">Remove</button>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6 text-right">
            <p class="text-lg font-semibold">Total: LKR {{ number_format($cartItems->sum('total_price'), 2) }}</p>
            <a href="{{ url('/checkout') }}" class="inline-block bg-black text-white py-2 px-6 rounded-md hover:bg-gray-800 mt-4 button-pulse">Proceed to Checkout</a>
        </div>
    @endif
</div>