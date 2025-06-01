<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Routing\Controller;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Request $request)
    {
        $request->validate([
            'delivery_address' => 'required|string|max:255',
        ]);

        try {
         
            return DB::connection('mongodb')->transaction(function () use ($request) {
                $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
                if ($cartItems->isEmpty()) {
                    return redirect()->route('cart.index')->with('error', 'Cart is empty.');
                }

             
                $totalPrice = $cartItems->sum('total_price');

              
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'ordered_date' => now(),
                    'delivery_address' => $request->delivery_address,
                    'order_status' => 'pending',
                    'total_price' => $totalPrice,
                ]);

    
                foreach ($cartItems as $cartItem) {
                    $product = $cartItem->product;
                    if ($product->stock_quantity < $cartItem->quantity) {
                        throw new \Exception('Insufficient stock for ' . $product->name);
                    }

                    OrderItem::create([
                        'order_id' => $order->_id,
                        'product_id' => $cartItem->product_id,
                        'quantity' => $cartItem->quantity,
                        'unit_price' => $product->price,
                        'total_price' => $cartItem->total_price,
                    ]);

                    $product->stock_quantity -= $cartItem->quantity;
                    $product->save();
                }

                // Clear cart
                Cart::where('user_id', Auth::id())->delete();

                return redirect()->route('order.confirmation', $order->_id)->with('success', 'Order placed successfully.');
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Order creation error: ' . $e->getMessage());
            return redirect()->route('cart.index')->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }

    public function confirmation($id)
    {
        $order = Order::with('items.product')
            ->where('user_id', Auth::id())
            ->where('_id', $id)
            ->firstOrFail();

        return view('order.confirmation', compact('order'));
    }
}