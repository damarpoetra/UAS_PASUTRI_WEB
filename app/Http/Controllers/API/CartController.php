<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product; // Pastikan model Product di-import agar nama & harga casing bisa ditarik

class CartController extends Controller
{
    // ===================================================================
    // 1. FUNGSI MENERIMA DAN MENYIMPAN DATA +KERANJANG KE MYSQL (POST)
    // ===================================================================
    public function addToCart(Request $request)
    {
        // Validasi data kiriman dari React lu (Sekarang phone_type juga wajib masuk)
        $request->validate([
            'product_id' => 'required',
            'quantity'   => 'required|integer',
            'phone_type' => 'required'
        ]);

        // Cek dulu di database: apakah barang dengan tipe HP yang sama udah pernah masuk?
        $existingCart = Cart::where('product_id', $request->product_id)
                            ->where('phone_type', $request->phone_type)
                            ->first();

        if ($existingCart) {
            // Kalau udah ada di MySQL, jumlahnya tinggal kita tambahkan (increment)
            $existingCart->increment('quantity', $request->quantity);
        } else {
            // KALAU BELUM ADA, BARU KITA INPUT DATA BARU BENERAN KE MYSQL!
            Cart::create([
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
                'phone_type' => $request->phone_type,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Mantap! Data resmi tersimpan permanen di database MySQL, Bos!'
        ], 200);
    }

    // ===================================================================
    // 2. FUNGSI MENGALIRKAN DATA DARI MYSQL KE HALAMAN KERANJANG REAC LU (GET)
    // ===================================================================
    public function getCart()
    {
        // Tarik data asli dari tabel carts MySQL
        $cartItems = Cart::all(); 
        
        $data = [];

        foreach ($cartItems as $item) {
            // Cari relasi data produk di database berdasarkan product_id buat dapet nama, harga, dan gambar asli
            $product = Product::find($item->product_id);

            $data[] = [
                'product_id'   => $item->product_id,
                'product_name' => $product ? $product->nama : 'Casing Custom', 
                'price'        => $product ? $product->harga : 39000, 
                'image'        => $product ? $product->gambar : 'https://via.placeholder.com/150',
                'quantity'     => $item->quantity,
                'phone_type'   => $item->phone_type
            ];
        }

        return response()->json([
            'success' => true,
            'data'    => $data
        ], 200);
    }
    public function deleteCartItem(Request $request, $product_id)
{
    // Ambil phone_type dari query string (?phone_type=...)
    $phone_type = $request->query('phone_type');

    // Kita cari datanya di database menggunakan string mentah agar tidak didebat oleh Laravel
    $cartItem = \App\Models\Cart::where('product_id', '=', (string)$product_id)
                                ->where('phone_type', '=', (string)$phone_type)
                                ->first();

    if ($cartItem) {
        $cartItem->delete(); // Hapus dari database MySQL
        
        return response()->json([
            'success' => true,
            'message' => 'Barang resmi lenyap dari database MySQL, Bos!'
        ], 200);
    }

    // Jika tidak ketemu, kita kirim pesan eror log ke terminal biar bisa dicek
    return response()->json([
        'success' => false,
        'message' => 'Gagal hapus, data tidak ditemukan di database dengan ID: ' . $product_id . ' dan Tipe: ' . $phone_type
    ], 404);
}
}