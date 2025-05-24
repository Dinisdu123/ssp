<?php

// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });



use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/leather-goods', [ProductController::class, 'leatherGoods'])->name('leather-goods');
Route::get('/fragrances', [ProductController::class, 'fragrances'])->name('fragrances');
Route::get('/accessories', [ProductController::class, 'accessories'])->name('accessories');
