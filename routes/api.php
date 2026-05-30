<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController; // <--- Tambahin ini
use Illuminate\Support\Facades\Route;

// Route untuk Auth (Register & Login)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Route untuk Katalog Produk
// Erin bakal akses ini lewat: http://127.0.0.1:8000/api/products
Route::get('/products', [ProductController::class, 'index']);

Route::post('/checkout', [ProductController::class, 'checkout']);
Route::get('/history', [ProductController::class, 'history']);
// Pake PUT atau PATCH biasanya buat update
Route::put('/products/{id}', [ProductController::class, 'update']);