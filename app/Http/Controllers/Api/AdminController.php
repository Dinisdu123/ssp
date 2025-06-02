<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    private function checkAdminRole(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }
        return true;
    }

    public function getProducts(Request $request)
    {
        if ($this->checkAdminRole($request) !== true) {
            return $this->checkAdminRole($request);
        }

        try {
            $products = Product::all();
            Log::info('API: Products fetched', ['count' => $products->count()]);
            return response()->json(['products' => $products], 200);
        } catch (\Exception $e) {
            Log::error('API: Products fetch error: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch products'], 500);
        }
    }

    public function getOrders(Request $request)
    {
        if ($this->checkAdminRole($request) !== true) {
            return $this->checkAdminRole($request);
        }

        try {
            $orders = Order::with(['user', 'items.product'])->get();
            Log::info('API: Orders fetched', ['count' => $orders->count()]);
            return response()->json(['orders' => $orders], 200);
        } catch (\Exception $e) {
            Log::error('API: Orders fetch error: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch orders'], 500);
        }
    }

    public function storeProduct(Request $request)
    {
        if ($this->checkAdminRole($request) !== true) {
            return $this->checkAdminRole($request);
        }

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

            $product = Product::create($validated);
            Log::info('API: Product created', ['id' => $product->id]);
            return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
        } catch (\Exception $e) {
            Log::error('API: Product store error: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to create product'], 500);
        }
    }

    public function updateProduct(Request $request, $id)
    {
        if ($this->checkAdminRole($request) !== true) {
            return $this->checkAdminRole($request);
        }

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
            Log::info('API: Product updated', ['id' => $id]);
            return response()->json(['message' => 'Product updated successfully', 'product' => $product], 200);
        } catch (\Exception $e) {
            Log::error('API: Product update error for ID ' . $id . ': ' . $e->getMessage());
            return response()->json(['error' => 'Unable to update product'], 500);
        }
    }

    public function deleteProduct(Request $request, $id)
    {
        if ($this->checkAdminRole($request) !== true) {
            return $this->checkAdminRole($request);
        }

        try {
            $product = Product::findOrFail($id);
            $product->delete();
            Log::info('API: Product deleted', ['id' => $id]);
            return response()->json(['message' => 'Product deleted successfully'], 200);
        } catch (\Exception $e) {
            Log::error('API: Product delete error for ID ' . $id . ': ' . $e->getMessage());
            return response()->json(['error' => 'Unable to delete product'], 500);
        }
    }

    public function updateOrderStatus(Request $request, $id)
    {
        if ($this->checkAdminRole($request) !== true) {
            return $this->checkAdminRole($request);
        }

        try {
            $request->validate([
                'order_status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            ]);

            $order = Order::findOrFail($id);
            $order->update(['order_status' => $request->order_status]);
            Log::info('API: Order status updated', ['id' => $id, 'status' => $request->order_status]);
            return response()->json(['message' => 'Order status updated successfully'], 200);
        } catch (\Exception $e) {
            Log::error('API: Order status update error for ID ' . $id . ': ' . $e->getMessage());
            return response()->json(['error' => 'Unable to update order status'], 500);
        }
    }

    public function getProduct(Request $request, $id)
    {
        if ($this->checkAdminRole($request) !== true) {
            return $this->checkAdminRole($request);
        }

        try {
            $product = Product::findOrFail($id);
            Log::info('API: Product fetched', ['id' => $id]);
            return response()->json(['product' => $product], 200);
        } catch (\Exception $e) {
            Log::error('API: Product fetch error for ID ' . $id . ': ' . $e->getMessage());
            return response()->json(['error' => 'Product not found'], 404);
        }
    }
}