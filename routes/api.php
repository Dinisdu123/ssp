<?php
use App\Http\Controllers\api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

// Authentication routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Existing route for authenticated user
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Admin routes 
Route::middleware(['auth:sanctum', 'abilities:admin-access', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/admin/orders', [AdminController::class, 'orders']);
    Route::get('/admin/add-item', [AdminController::class, 'addItem']);
    Route::post('/admin/products', [AdminController::class, 'storeProduct']);
    Route::put('/admin/orders/{id}/status', [AdminController::class, 'updateOrderStatus']);
    Route::delete('/admin/products/{id}', [AdminController::class, 'deleteProduct']);
    Route::get('/admin/products/{id}/edit', [AdminController::class, 'editProduct']);
    Route::put('/admin/products/{id}', [AdminController::class, 'updateProduct']);
});

//Customer routes
use App\Http\Controllers\API\ProductController;

Route::get('/products/fragrances', [ProductController::class, 'fragrances']);
Route::get('/products/leather-goods', [ProductController::class, 'leatherGoods']);
Route::get('/products/accessories', [ProductController::class, 'accessories']);
