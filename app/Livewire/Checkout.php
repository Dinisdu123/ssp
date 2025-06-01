<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Checkout extends Component
{
    public $deliveryAddress = '';

    protected $rules = [
        'deliveryAddress' => 'required|string|min:5|max:500',
    ];

    public function mount()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Please log in to proceed to checkout.');
            return redirect()->route('login');
        }

        // Ensure cart is not empty
        $cartItems = Cart::where('user_id', Auth::id())->count();
        if ($cartItems === 0) {
            session()->flash('error', 'Your cart is empty.');
            return redirect()->route('cart.index');
        }
    }

    public function placeOrder()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $cartItems = Cart::with('product')
                ->where('user_id', Auth::id())
                ->get();

            // Calculate total price
            $totalPrice = $cartItems->sum('total_price');

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'ordered_date' => now(),
                'delivery_address' => $this->deliveryAddress,
                'order_status' => 'Pending',
                'total_price' => $totalPrice,
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->_id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product->price + 0, 
                    'total_price' => $item->total_price,
                ]);
            }

            // Clear cart
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();
            session()->flash('success', 'Order placed successfully!');
            return redirect()->route('order.confirmation', $order->_id);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout Error: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while placing your order. Please try again.');
        }
    }

    public function render()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $totalPrice = $cartItems->sum('total_price');

        return view('livewire.checkout', compact('cartItems', 'totalPrice'));
    }
}