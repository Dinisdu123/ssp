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
                                <td class="py-3 px-4 font-lora text-sm">{{ e(Str::limit($product->description ?? 'N/A', 50)) }}</td>
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
                                    <button class="edit-product bg-blue-600 text-white py-1 px-3 rounded-md hover:bg-blue-700 font-lora text-sm"
                                            data-id="{{ $product->_id }}"
                                            data-name="{{ json_encode($product->name ?? 'N/A') }}"
                                            data-description="{{ json_encode($product->description ?? 'N/A') }}"
                                            data-image-url="{{ json_encode($product->image_url ?? 'https://via.placeholder.com/64') }}"
                                            data-price="{{ $product->price ?? 0 }}"
                                            data-stock-quantity="{{ $product->stock_quantity ?? 0 }}"
                                            data-category="{{ json_encode($product->category ?? 'N/A') }}"
                                            data-sub-category="{{ json_encode($product->sub_category ?? 'N/A') }}">Edit</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Edit Product Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-md shadow-md w-full max-w-lg">
            <h3 class="text-lg font-semibold font-cinzel mb-4">Edit Product</h3>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="editId">
                <div class="mb-4">
                    <label for="editName" class="block text-sm font-cinzel text-black">Name</label>
                    <input type="text" name="name" id="editName" class="w-full border p-2 rounded-md font-lora" required>
                </div>
                <div class="mb-4">
                    <label for="editDescription" class="block text-sm font-cinzel text-black">Description</label>
                    <textarea name="description" id="editDescription" class="w-full border p-2 rounded-md font-lora" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="editImageUrl" class="block text-sm font-cinzel text-black">Image URL</label>
                    <input type="text" name="image_url" id="editImageUrl" class="w-full border p-2 rounded-md font-lora" required>
                </div>
                <div class="mb-4">
                    <label for="editPrice" class="block text-sm font-cinzel text-black">Price (LKR)</label>
                    <input type="number" step="0.01" name="price" id="editPrice" class="w-full border p-2 rounded-md font-lora" required>
                </div>
                <div class="mb-4">
                    <label for="editStockQuantity" class="block text-sm font-cinzel text-black">Stock Quantity</label>
                    <input type="number" name="stock_quantity" id="editStockQuantity" class="w-full border p-2 rounded-md font-lora" required>
                </div>
                <div class="mb-4">
                    <label for="editCategory" class="block text-sm font-cinzel text-black">Category</label>
                    <input type="text" name="category" id="editCategory" class="w-full border p-2 rounded-md font-lora" required>
                </div>
                <div class="mb-4">
                    <label for="editSubCategory" class="block text-sm font-cinzel text-black">Sub Category</label>
                    <input type="text" name="sub_category" id="editSubCategory" class="w-full border p-2 rounded-md font-lora" required>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeEditModal()" class="bg-gray-600 text-white py-2 px-4 rounded-md hover:bg-gray-700 font-lora">Cancel</button>
                    <button type="submit" class="button-pulse py-2 px-4 rounded-md font-lora text-black">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            console.log('Edit buttons found:', document.querySelectorAll('.edit-product').length);
            document.querySelectorAll('.edit-product').forEach(button => {
                button.addEventListener('click', function () {
                    console.log('Edit clicked:', this.dataset);
                    const id = this.dataset.id;
                    const name = JSON.parse(this.dataset.name);
                    const description = JSON.parse(this.dataset.description);
                    const image_url = JSON.parse(this.dataset.imageUrl);
                    const price = parseFloat(this.dataset.price);
                    const stock_quantity = parseInt(this.dataset.stockQuantity);
                    const category = JSON.parse(this.dataset.category);
                    const sub_category = JSON.parse(this.dataset.subCategory);
                    openEditModal(id, name, description, image_url, price, stock_quantity, category, sub_category);
                });
            });
        });

        function openEditModal(id, name, description, image_url, price, stock_quantity, category, sub_category) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editId').value = id;
            document.getElementById('editName').value = name;
            document.getElementById('editDescription').value = description;
            document.getElementById('editImageUrl').value = image_url;
            document.getElementById('editPrice').value = price;
            document.getElementById('editStockQuantity').value = stock_quantity;
            document.getElementById('editCategory').value = category;
            document.getElementById('editSubCategory').value = sub_category;
            document.getElementById('editForm').action = '/admin/product/update/' + id;
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</x-app-layout>