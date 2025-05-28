<?php


namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $newArrivals = Product::bySubCategory('New Arrivals')->get();
        return view('index', compact('newArrivals'));
    }

    public function leatherGoods()
    {
        $products = Product::byCategory('leather-goods')->get()->groupBy('sub_category');
        $shoulderBags = $products['shoulder bags'] ?? collect([]);
        $miniBags = $products['minibags'] ?? collect([]);
        $backpacks = $products['backpacks'] ?? collect([]);
        $wallets = $products['wallets'] ?? collect([]);
        return view('leather-goods', compact('shoulderBags', 'miniBags', 'backpacks', 'wallets'));
    }

    public function fragrances()
    {
        $products = Product::byCategory('fragrance')->get()->groupBy('sub_category');
        $mens = $products['mens'] ?? collect([]);
        $ladies = $products['ladies'] ?? collect([]);
        return view('fragrances', compact('mens', 'ladies'));
    }

    public function accessories()
    {
        $products = Product::byCategory('accessories')->get()->groupBy('sub_category');
        $jewellery = $products['jewellery'] ?? collect([]);
        $footwear = $products['footwear'] ?? collect([]);
        return view('accessories', compact('jewellery', 'footwear'));
    }

    // public function show($id)
    // {
    //     $product = Product::findOrFail($id);
    //     $reviews = Review::with('user')
    //         ->where('product_id', $id)
    //         ->orderBy('review_date', 'desc')
    //         ->get();

    //     return view('product.show', compact('product', 'reviews'));
    // }
    public function show($id)
{
    $product = Product::with('reviews.user')->findOrFail($id);
    return view('product.show', compact('product'));
}

//     public function addToCart(Request $request, $id)
//     {
//         if (!Auth::check()) {
//             return redirect()->route('login')->with('error', 'Please log in to add items to your cart.');
//         }

//         $request->validate([
//             'quantity' => 'required|integer|min:1',
//         ]);

//         $product = Product::findOrFail($id);
//         $userId = Auth::id();
//         $quantity = $request->input('quantity');
//         $totalPrice = $quantity * ($product->price + 400); // Legacy code adds 400 to price

//         $cartItem = Cart::where('user_id', $userId)
//             ->where('product_id', $id)
//             ->first();
//         if ($cartItem) {
//             $cartItem->quantity += $quantity;
//             $cartItem->total_price = $cartItem->quantity * ($product->price + 400);
//             $cartItem->save();
//         } else {
//             Cart::create([
//                 'user_id' => $userId,
//                 'product_id' => $id,
//                 'quantity' => $quantity,
//                 'total_price' => $totalPrice,
//             ]);
//         }

//         return redirect()->route('cart.index')->with('success', 'Product added to cart successfully.');
//     }
// }
public function addToCart(Request $request, $id)
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Please log in to add items to your cart.');
    }

    $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    try {
        $product = Product::findOrFail($id);
        if ($product->stock_quantity < $request->quantity) {
            return redirect()->back()->with('error', 'Insufficient stock for ' . $product->name);
        }

        $userId = Auth::id();
        $quantity = $request->input('quantity');
        $totalPrice = $quantity * ($product->price + config('pricing.additional_fee'));

        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $id)
            ->first();
        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            if ($product->stock_quantity < $newQuantity) {
                return redirect()->back()->with('error', 'Insufficient stock for ' . $product->name);
            }
            $cartItem->quantity = $newQuantity;
            $cartItem->total_price = $newQuantity * ($product->price + config('pricing.additional_fee'));
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $id,
                'quantity' => $quantity,
                'total_price' => $totalPrice,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully.');
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Add to cart error for product ID ' . $id . ': ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to add product to cart.');
    }
}
}
