<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request) // <--- Tambahin Request $request di sini
    {
        // Ambil input "search" dari URL (misal: ?search=iphone)
        $search = $request->query('search');

        if ($search) {
            // Kalau user lagi nyari, filter berdasarkan Nama atau Tipe HP
            $products = Product::where('nama', 'LIKE', "%{$search}%")
                                ->orWhere('tipe_hp', 'LIKE', "%{$search}%")
                                ->get();
        } else {
            // Kalau nggak ada pencarian, kasih semua datanya
            $products = Product::all();
        }

        return response()->json($products);
    }


public function checkout(Request $request)
{
    // 1. Validasi input dari Erin
    $request->validate([
        'product_id' => 'required',
        'jumlah' => 'required|integer|min:1',
        'nama_pembeli' => 'required',
        'alamat' => 'required',
    ]);

    // 2. Cari produknya
    $product = Product::find($request->product_id);

    // 3. Cek stok cukup gak?
    if ($product->stok < $request->jumlah) {
        return response()->json(['message' => 'Stok tidak cukup bro!'], 400);
    }

    // 4. Itung total harga & Kurangi stok
    $total_harga = $product->harga * $request->jumlah;
    $product->stok -= $request->jumlah;
    $product->save();

    // 5. Simpan pesanan ke tabel orders
    $order = Order::create([
        'product_id' => $request->product_id,
        'jumlah' => $request->jumlah,
        'total_harga' => $total_harga,
        'nama_pembeli' => $request->nama_pembeli,
        'alamat' => $request->alamat,
    ]);

    return response()->json([
        'message' => 'Checkout Berhasil!',
        'data' => $order
    ]);
}
public function history()
{
    // Ambil semua data pesanan, urutkan dari yang terbaru
   $orders = Order::orderBy('created_at', 'desc')->get();

    return response()->json([
        'message' => 'Daftar Riwayat Pesanan',
        'data'    => $orders
    ]);
}
// Fungsi buat edit/update data produk
public function update(Request $request, $id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json(['message' => 'Barang gak ada, mau update apaan bro?'], 404);
    }

    // Validasi input (opsional, tapi bagus buat jaga-jaga)
    $request->validate([
        'nama' => 'sometimes|required',
        'tipe_hp' => 'sometimes|required',
        'harga' => 'sometimes|required|integer',
        'stok' => 'sometimes|required|integer',
    ]);

    // Update data dengan apa yang dikirim di request
    $product->update($request->all());

    return response()->json([
        'message' => 'Data produk berhasil diupdate!',
        'data' => $product
    ]);
}
}

