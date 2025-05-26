<?php
namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function dashboard()
    {
        try {
            $products = Product::all();
            Log::info('Products fetched for dashboard', ['count' => $products->count(), 'products' => $products->toArray()]);
            return view('admin.dashboard', compact('products'));
        } catch (\Exception $e) {
            Log::error('Admin dashboard error: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Unable to load dashboard');
        }
    }

    public function orders()
    {
        try {
            $orders = Order::with(['user', 'items.product'])->get();
            Log::info('Orders fetched for admin', ['count' => $orders->count(), 'orders' => $orders->toArray()]);
            return view('admin.orders', compact('orders'));
        } catch (\Exception $e) {
            Log::error('Admin orders error: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', 'Unable to load orders');
        }
    }

    public function addItem()
    {
        return view('admin.add-item');
    }

    public function storeProduct(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'image_url' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'stock_quantity' => 'required|integer|min:0',
                'category' => 'required|in:leather-goods,fragrance,accessories',
                'sub_category' => 'required|in:shoulder bags,minibags,backpacks,wallets,mens,ladies,jewellery,footwear',
            ]);

            Product::create($validated);

            return redirect()->route('admin.add-item')->with('success', 'Product added successfully');
        } catch (\Exception $e) {
            Log::error('Product store error: ' . $e->getMessage());
            return redirect()->route('admin.add-item')->with('error', 'Unable to add product');
        }
    }

    public function updateOrderStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'order_status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            ]);

            $order = Order::findOrFail($id);
            $order->update(['order_status' => $request->order_status]);

            return redirect()->route('admin.orders')->with('success', 'Order status updated successfully');
        } catch (\Exception $e) {
            Log::error('Order status update error for ID ' . $id . ': ' . $e->getMessage());
            return redirect()->route('admin.orders')->with('error', 'Unable to update order status');
        }
    }

    public function deleteProduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return redirect()->route('admin.dashboard')->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            Log::error('Product delete error for ID ' . $id . ': ' . $e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', 'Unable to delete product');
        }
    }

    public function editProduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            Log::info('Editing product', ['id' => $id]);
            return view('admin.product.edit', compact('product'));
        } catch (\Exception $e) {
            Log::error('Error fetching product for edit: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', 'Product not found');
        }
    }
    public function updateProduct(Request $request, $id)
    {
        Log::info('Update request data:', $request->all());
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'image_url' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'stock_quantity' => 'required|integer|min:0',
                'category' => 'required|in:leather-goods,fragrance,accessories',
                'sub_category' => 'required|in:shoulder bags,minibags,backpacks,wallets,mens,ladies,jewellery,footwear',
            ]);
            $product = Product::findOrFail($id);
            $product->update($validated);
            Log::info('Product updated', ['id' => $id]);
            return redirect()->route('admin.dashboard')->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            Log::error('Product update error for ID ' . $id . ': ' . $e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', 'Unable to update product: ' . $e->getMessage());
        }
    }
}
