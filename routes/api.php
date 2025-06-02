<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DataController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products/fragrances', [ProductController::class, 'fragrances']);
Route::get('/products/leather-goods', [ProductController::class, 'leatherGoods']);
Route::get('/products/accessories', [ProductController::class, 'accessories']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/data', [DataController::class, 'index']);
    
    // Admin routes 
    Route::middleware('abilities:admin-access')->group(function () {
        Route::get('/products', [AdminController::class, 'getProducts']);
        Route::get('/products/{id}', [AdminController::class, 'getProduct']);
        Route::post('/products', [AdminController::class, 'storeProduct'])->middleware('ability:product:manage');
        Route::put('/products/{id}', [AdminController::class, 'updateProduct'])->middleware('ability:product:manage');
        Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])->middleware('ability:product:manage');
        Route::get('/orders', [AdminController::class, 'getOrders']);
        Route::put('/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->middleware('ability:order:manage');
    });
});