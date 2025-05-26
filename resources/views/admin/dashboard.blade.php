<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight font-cinzel">Admin Dashboard</h2>
    </x-slot>

    <div class="container mx-auto px-4 py-12">
        <!-- Navigation Buttons -->
        <div class="flex space-x-4 mb-8">
            <a href="{{ route('admin.dashboard') }}" class="button-pulse py-2 px-4 rounded-md font-cinzel text-black uppercase tracking-wider">Dashboard</a>
            <a href="{{ route('admin.orders') }}" class="button-pulse py-2 px-4 rounded-md font-cinzel text-black uppercase tracking-wider">Orders</a>
            <a href="{{ route('admin.add-item') }}" class="button-pulse py-2 px-4 rounded-md font-cinzel text-black uppercase tracking-wider">Add Item</a>
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
                                    <a href="{{ route('admin.product.edit', $product->_id) }}" class="bg-blue-600 text-black py-1 px-3 rounded-md hover:bg-blue-700 font-lora text-sm">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>