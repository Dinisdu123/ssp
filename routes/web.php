<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
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
Route::get('/order/confirmation/{id}', [OrderController::class, 'confirmation'])->name('order.confirmation')->middleware('auth');
Route::get('/checkout', function () {
    return view('cart.checkout');
})->name('checkout')->middleware('auth');

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

//admin routes
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/admin/add-item', [AdminController::class, 'addItem'])->name('admin.add-item');
    Route::post('/admin/product/store', [AdminController::class, 'storeProduct'])->name('admin.product.store');
    Route::delete('/admin/product/{id}', [AdminController::class, 'deleteProduct'])->name('admin.product.delete');
    Route::get('/admin/product/edit/{id}', [AdminController::class, 'editProduct'])->name('admin.product.edit');
    Route::put('/admin/product/update/{id}', [AdminController::class, 'updateProduct'])->name('admin.product.update');
    Route::patch('/admin/order/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.order.update-status');


