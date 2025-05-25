<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight font-cinzel">Add Product</h2>
    </x-slot>

    <div class="container mx-auto px-4 py-12">
        <!-- Navigation Buttons -->
        <div class="flex space-x-4 mb-8">
            <a href="{{ route('admin.dashboard') }}" class="button-pulse py-2 px-4 rounded-md font-cinzel text-black uppercase tracking-wider">Dashboard</a>
            <a href="{{ route('admin.orders') }}" class="button-pulse py-2 px-4 rounded-md font-cinzel text-black uppercase tracking-wider">Orders</a>
            <a href="{{ route('admin.add-item') }}" class="button-pulse py-2 px-4 rounded-md font-cinzel text-black uppercase tracking-wider">Add Item</a>
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
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full border p-2 rounded-md font-lora" required>
                    @error('name')
                        <p class="text-red-600 text-sm font-lora mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-cinzel text-black">Description</label>
                    <textarea name="description" id="description" class="w-full border p-2 rounded-md font-lora" required>{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-600 text-sm font-lora mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="image_url" class="block text-sm font-cinzel text-black">Image URL</label>
                    <input type="text" name="image_url" id="image_url" value="{{ old('image_url') }}" class="w-full border p-2 rounded-md font-lora" required>
                    @error('image_url')
                        <p class="text-red-600 text-sm font-lora mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="price" class="block text-sm font-cinzel text-black">Price (LKR)</label>
                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" class="w-full border p-2 rounded-md font-lora" required>
                    @error('price')
                        <p class="text-red-600 text-sm font-lora mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="stock_quantity" class="block text-sm font-cinzel text-black">Stock Quantity</label>
                    <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity') }}" class="w-full border p-2 rounded-md font-lora" required>
                    @error('stock_quantity')
                        <p class="text-red-600 text-sm font-lora mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="category" class="block text-sm font-cinzel text-black">Category</label>
                    <select name="category" id="category" class="w-full border p-2 rounded-md font-lora" required>
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
                    <select name="sub_category" id="sub_category" class="w-full border p-2 rounded-md font-lora" required>
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
                    <button type="submit" class="button-pulse py-2 px-4 rounded-md font-lora text-black">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>