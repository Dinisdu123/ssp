<div>
    @if (session()->has('error'))
        <div class="text-red-600 mb-4">{{ session('error') }}</div>
    @endif
    @if (session()->has('success'))
        <div class="text-green-600 mb-4">{{ session('success') }}</div>
    @endif

    <h2 class="text-xl sm:text-2xl font-semibold mb-6">Order Summary</h2>
    @if ($cartItems->isEmpty())
        <p class="text-gray-600">Your cart is empty.</p>
    @else
        <div class="space-y-4 mb-8">
            @foreach ($cartItems as $item)
                <div class="flex flex-col sm:flex-row items-center justify-between border p-4 rounded-md bg-gray-50">
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset($item->product->image_url ?? $item->product->image) }}" alt="{{ e($item->product->name) }}" class="w-16 h-16 object-cover rounded">
                        <div>
                            <h3 class="font-semibold">{{ e($item->product->name) }}</h3>
                            <p class="text-gray-600">LKR {{ number_format($item->product->price, 2) }}</p>
                            <p class="text-gray-600">Quantity: {{ $item->quantity }}</p>
                        </div>
                    </div>
                    <p class="text-gray-600 mt-2 sm:mt-0">Total: LKR {{ number_format($item->total_price, 2) }}</p>
                </div>
            @endforeach
            <div class="text-right">
                <p class="text-lg font-semibold">Total: LKR {{ number_format($totalPrice, 2) }}</p>
            </div>
        </div>

        <h2 class="text-xl sm:text-2xl font-semibold mb-4">Delivery Details & Phone number</h2>
        <form wire:submit.prevent="placeOrder">
            <div class="mb-4">
                <label for="delivery_address" class="block text-sm font-medium text-gray-700">Delivery Address</label>
                <textarea wire:model="deliveryAddress" id="delivery_address" rows="4" class="border p-2 rounded-md w-full"></textarea>
                @error('deliveryAddress') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="bg-black text-white py-2 px-6 rounded-md hover:bg-gray-800 button-pulse">Place Order</button>
        </form>
    @endif
</div>