<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $newArrivals = Product::where('SubCategory', 'New Arrivals')->get();
        return view('index', compact('newArrivals'));
    }

    public function leatherGoods()
    {
        $shoulderBags = Product::where('Category', 'leather goods')->where('SubCategory', 'shoulder bags')->get();
        $miniBags = Product::where('Category', 'leather goods')->where('SubCategory', 'minibags')->get();
        $backpacks = Product::where('Category', 'leather goods')->where('SubCategory', 'backpacks')->get();
        $wallets = Product::where('Category', 'leather goods')->where('SubCategory', 'wallets')->get();
        return view('leather-goods', compact('shoulderBags', 'miniBags', 'backpacks', 'wallets'));
    }

    public function fragrances()
    {
        $mens = Product::where('Category', 'fragrance')->where('SubCategory', 'mens')->get();
        $ladies = Product::where('Category', 'fragrance')->where('SubCategory', 'ladies')->get();
        return view('fragrances', compact('mens', 'ladies'));
    }

    // public function accessories()
    // {
    //     $jewelleries = Product::where('Category', 'accessories')->where('SubCategory', 'jewelleries')->get();
    //     $footwear = Product::where('Category', 'accessories')->where('SubCategory', 'footwear')->get();
    //     return view('accessories', compact('jewelleries', 'footwear'));
    // }
    public function accessories()
{
    $jewellery = Product::where('SubCategory', 'jewellery')->get();
    $footwear = Product::where('SubCategory', 'footwear')->get();
    return view('accessories', compact('jewellery', 'footwear'));
}
}