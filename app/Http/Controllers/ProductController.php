<?php

// namespace App\Http\Controllers;

// use App\Models\Product;
// use Illuminate\Http\Request;
// use App\Models\Cart;
// use App\Models\Review;
// use Illuminate\Support\Facades\Auth;

// class ProductController extends Controller
// {
//     public function index()
//     {
//         $newArrivals = Product::where('SubCategory', 'New Arrivals')->get();
//         return view('index', compact('newArrivals'));
//     }

//     public function leatherGoods()
//     {
//         $shoulderBags = Product::where('Category', 'leather goods')->where('SubCategory', 'shoulder bags')->get();
//         $miniBags = Product::where('Category', 'leather goods')->where('SubCategory', 'minibags')->get();
//         $backpacks = Product::where('Category', 'leather goods')->where('SubCategory', 'backpacks')->get();
//         $wallets = Product::where('Category', 'leather goods')->where('SubCategory', 'wallets')->get();
//         return view('leather-goods', compact('shoulderBags', 'miniBags', 'backpacks', 'wallets'));
//     }

//     public function fragrances()
//     {
//         $mens = Product::where('Category', 'fragrance')->where('SubCategory', 'mens')->get();
//         $ladies = Product::where('Category', 'fragrance')->where('SubCategory', 'ladies')->get();
//         return view('fragrances', compact('mens', 'ladies'));
//     }
//     public function accessories()
// {
//     $jewellery = Product::where('SubCategory', 'jewellery')->get();
//     $footwear = Product::where('SubCategory', 'footwear')->get();
//     return view('accessories', compact('jewellery', 'footwear'));
// }
// public function show($id)
//     {
//         $product = Product::findOrFail($id);
//         $reviews = Review::with('user')
//             ->where('product_id', $id)
//             ->orderBy('review_date', 'desc')
//             ->get();

//         return view('product.show', compact('product', 'reviews'));
//     }

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
//             if ($cartItem) {
//                 $cartItem->quantity += $quantity;
//                 $cartItem->total_price = $cartItem->quantity * ($product->price + 400);
//                 $cartItem->save();
//             } else {
//                 Cart::create([
//                     'user_id' => $userId,
//                     'product_id' => $id,
//                     'quantity' => $quantity,
//                     'total_price' => $totalPrice,
//                 ]);
//             }
    
//             return redirect()->route('cart.index')->with('success', 'Product added to cart successfully.');
//         }


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
        $newArrivals = Product::where('sub_category', 'New Arrivals')->get();
        return view('index', compact('newArrivals'));
    }

    public function leatherGoods()
    {
        $shoulderBags = Product::where('category', 'leather-goods')->where('sub_category', 'shoulder bags')->get();
        $miniBags = Product::where('category', 'leather-goods')->where('sub_category', 'minibags')->get();
        $backpacks = Product::where('category', 'leather-goods')->where('sub_category', 'backpacks')->get();
        $wallets = Product::where('category', 'leather-goods')->where('sub_category', 'wallets')->get();
        return view('leather-goods', compact('shoulderBags', 'miniBags', 'backpacks', 'wallets'));
    }

    public function fragrances()
    {
        $mens = Product::where('category', 'fragrance')->where('sub_category', 'mens')->get();
        $ladies = Product::where('category', 'fragrance')->where('sub_category', 'ladies')->get();
        return view('fragrances', compact('mens', 'ladies'));
    }

    public function accessories()
    {
        $jewellery = Product::where('sub_category', 'jewellery')->get();
        $footwear = Product::where('sub_category', 'footwear')->get();
        return view('accessories', compact('jewellery', 'footwear'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $reviews = Review::with('user')
            ->where('product_id', $id)
            ->orderBy('review_date', 'desc')
            ->get();

        return view('product.show', compact('product', 'reviews'));
    }

    public function addToCart(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to add items to your cart.');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($id);
        $userId = Auth::id();
        $quantity = $request->input('quantity');
        $totalPrice = $quantity * ($product->price + 400); // Legacy code adds 400 to price

        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $id)
            ->first();
        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->total_price = $cartItem->quantity * ($product->price + 400);
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
    }
}
