<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartManager extends Component
{
    public $cartItems;

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();
    }

    public function updateQuantity($cartItemId, $quantity)
    {
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('_id', $cartItemId)
            ->firstOrFail();

        $product = Product::findOrFail($cartItem->product_id);

        if ($quantity < 1) {
            $quantity = 1; 
        }

        $cartItem->quantity = $quantity;
        $cartItem->total_price = $quantity * ($product->price + 00);
        $cartItem->save();

        $this->loadCart(); 
        $this->dispatch('cartUpdated');
    }

    public function removeItem($cartItemId)
    {
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('_id', $cartItemId)
            ->firstOrFail();

        $cartItem->delete();

        $this->loadCart();
        $this->dispatch('cartUpdated');
    }

    public function render()
    {
        return view('livewire.cart-manager');
    }
}