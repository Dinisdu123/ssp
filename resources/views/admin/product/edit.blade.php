<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight font-cinzel">Edit Product</h2>
    </x-slot>

    <div class="container mx-auto px-4 py-12">
        <h3 class="text-lg font-semibold text-black font-cinzel uppercase tracking-wider mb-4">Edit Product</h3>
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

        <form method="POST" action="{{ route('admin.product.update', $product->_id) }}" class="bg-white p-6 rounded-md shadow-md w-full max-w-lg mx-auto">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-sm font-cinzel text-black">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name ?? 'N/A') }}" class="w-full border p-2 rounded-md font-lora" required>
                @error('name')
                    <span class="text-red-600 text-sm font-lora">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-cinzel text-black">Description</label>
                <textarea name="description" id="description" class="w-full border p-2 rounded-md font-lora" required>{{ old('description', $product->description ?? 'N/A') }}</textarea>
                @error('description')
                    <span class="text-red-600 text-sm font-lora">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="image_url" class="block text-sm font-cinzel text-black">Image URL</label>
                <input type="text" name="image_url" id="image_url" value="{{ old('image_url', $product->image_url ?? 'https://via.placeholder.com/64') }}" class="w-full border p-2 rounded-md font-lora" required>
                @error('image_url')
                    <span class="text-red-600 text-sm font-lora">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="price" class="block text-sm font-cinzel text-black">Price (LKR)</label>
                <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $product->price ?? 0) }}" class="w-full border p-2 rounded-md font-lora" required>
                @error('price')
                    <span class="text-red-600 text-sm font-lora">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="stock_quantity" class="block text-sm font-cinzel text-black">Stock Quantity</label>
                <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity ?? 0) }}" class="w-full border p-2 rounded-md font-lora" required>
                @error('stock_quantity')
                    <span class="text-red-600 text-sm font-lora">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="category" class="block text-sm font-cinzel text-black">Category</label>
                <select name="category" id="category" class="w-full border p-2 rounded-md font-lora" required>
                    <option value="leather-goods" {{ old('category', $product->category ?? '') === 'leather-goods' ? 'selected' : '' }}>Leather Goods</option>
                    <option value="fragrance" {{ old('category', $product->category ?? '') === 'fragrance' ? 'selected' : '' }}>Fragrance</option>
                    <option value="accessories" {{ old('category', $product->category ?? '') === 'accessories' ? 'selected' : '' }}>Accessories</option>
                </select>
                @error('category')
                    <span class="text-red-600 text-sm font-lora">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="sub_category" class="block text-sm font-cinzel text-black">Sub Category</label>
                <select name="sub_category" id="sub_category" class="w-full border p-2 rounded-md font-lora" required>
                    <option value="shoulder bags" {{ old('sub_category', $product->sub_category ?? '') === 'shoulder bags' ? 'selected' : '' }}>Shoulder Bags</option>
                    <option value="minibags" {{ old('sub_category', $product->sub_category ?? '') === 'minibags' ? 'selected' : '' }}>Minibags</option>
                    <option value="backpacks" {{ old('backpacks', $product->sub_category ?? '') === 'backpacks' ? 'selected' : '' }}>Backpacks</option>
                    <option value="wallets" {{ old('sub_category', $product->sub_category ?? '') === 'wallets' ? 'selected' : '' }}>Wallets</option>
                    <option value="mens" {{ old('sub_category', $product->sub_category ?? '') === 'mens' ? 'selected' : '' }}>Mens</option>
                    <option value="ladies" {{ old('sub_category', $product->sub_category ?? '') === 'ladies' ? 'selected' : '' }}>Ladies</option>
                    <option value="jewellery" {{ old('sub_category', $product->sub_category ?? '') === 'jewellery' ? 'selected' : '' }}>Jewellery</option>
                    <option value="footwear" {{ old('sub_category', $product->sub_category ?? '') === 'footwear' ? 'selected' : '' }}>Footwear</option>
                </select>
                @error('sub_category')
                    <span class="text-red-600 text-sm font-lora">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex justify-end space-x-2">
                <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 text-black py-2 px-4 rounded-md hover:bg-gray-700 font-lora">Cancel</a>
                <button type="submit" class="button-pulse py-2 px-4 rounded-md font-lora text-black">Save</button>
            </div>
        </form>
    </div>
</x-app-layout>