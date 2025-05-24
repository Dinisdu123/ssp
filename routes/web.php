<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/leather-goods', [ProductController::class, 'leatherGoods'])->name('leather-goods');
Route::get('/fragrances', [ProductController::class, 'fragrances'])->name('fragrances');
Route::get('/accessories', [ProductController::class, 'accessories'])->name('accessories');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::post('/product/{id}/add-to-cart', [ProductController::class, 'addToCart'])->name('product.addToCart')->middleware('auth');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index')->middleware('auth');
Route::post('/cart/{id}/update', [CartController::class, 'update'])->name('cart.update')->middleware('auth');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy')->middleware('auth');
Route::get('/checkout', function () {
    return view('cart.checkout');
})->name('checkout')->middleware('auth');
Route::get('/order/confirmation/{id}', [OrderController::class, 'confirmation'])->name('order.confirmation')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/user/profile', function () {
        $orders = \App\Models\Order::with('items.product')
            ->where('user_id', \Illuminate\Support\Facades\Auth::user()->id)
            ->latest('ordered_date')
            ->get();
        return view('profile.show', compact('orders'));
    })->name('profile.show');
    Route::get('/dashboard', function () {
        return redirect()->route('profile.show');
    })->name('dashboard');
});