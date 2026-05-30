<?php

namespace App\Http\Controllers;

use App\Models\Product; // <--- Ini penting biar dia kenal tabel produk
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Ngambil semua produk dari database
        $products = Product::all();

        // Kasih respon ke Erin (Frontend)
        return response()->json($products);
    }
}