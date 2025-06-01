<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function fragrances()
    {
        $products = Product::byCategory('fragrance')->get()->groupBy('sub_category');
        $mens = $products['mens'] ?? collect([]);
        $ladies = $products['ladies'] ?? collect([]);
        $fragrances = [
            'mens' => $mens->map(function ($product) {
                return [
                    'id' => (string) $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'image_url' => $product->image_url,
                    'price' => $product->price,
                ];
            }),
            'ladies' => $ladies->map(function ($product) {
                return [
                    'id' => (string) $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'image_url' => $product->image_url,
                    'price' => $product->price,
                ];
            }),
        ];
        return response()->json($fragrances);
    }

    public function leatherGoods()
    {
        $products = Product::byCategory('leather-goods')->get()->groupBy('sub_category');
        $shoulderBags = $products['shoulder bags'] ?? collect([]);
        $miniBags = $products['minibags'] ?? collect([]);
        $backpacks = $products['backpacks'] ?? collect([]);
        $wallets = $products['wallets'] ?? collect([]);
        $leatherGoods = [
            'shoulder_bags' => $shoulderBags->map(function ($product) {
                return [
                    'id' => (string) $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'image_url' => $product->image_url,
                    'price' => $product->price,
                ];
            }),
            'minibags' => $miniBags->map(function ($product) {
                return [
                    'id' => (string) $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'image_url' => $product->image_url,
                    'price' => $product->price,
                ];
            }),
            'backpacks' => $backpacks->map(function ($product) {
                return [
                    'id' => (string) $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'image_url' => $product->image_url,
                    'price' => $product->price,
                ];
            }),
            'wallets' => $wallets->map(function ($product) {
                return [
                    'id' => (string) $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'image_url' => $product->image_url,
                    'price' => $product->price,
                ];
            }),
        ];
        return response()->json($leatherGoods);
    }

    public function accessories()
    {
        $products = Product::byCategory('accessories')->get()->groupBy('sub_category');
        $jewellery = $products['jewellery'] ?? collect([]);
        $footwear = $products['footwear'] ?? collect([]);
        $accessories = [
            'jewellery' => $jewellery->map(function ($product) {
                return [
                    'id' => (string) $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'image_url' => $product->image_url,
                    'price' => $product->price,
                ];
            }),
            'footwear' => $footwear->map(function ($product) {
                return [
                    'id' => (string) $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'image_url' => $product->image_url,
                    'price' => $product->price,
                ];
            }),
        ];
        return response()->json($accessories);
    }
}