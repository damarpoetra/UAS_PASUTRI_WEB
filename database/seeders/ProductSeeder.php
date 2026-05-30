<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product; // <--- Penting!

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Data Casing 1
        Product::create([
            'nama' => 'Casing Silicon Pastel',
            'tipe_hp' => 'iPhone 13',
            'harga' => 45000,
            'stok' => 20,
            'deskripsi' => 'Bahan silicon lembut, anti sidik jari.'
        ]);

        // Data Casing 2
        Product::create([
            'nama' => 'Hardcase Carbon Fiber',
            'tipe_hp' => 'Samsung S23',
            'harga' => 75000,
            'stok' => 15,
            'deskripsi' => 'Bahan kuat, tahan banting, desain elegan.'
        ]);

        // Data Casing 3
        Product::create([
            'nama' => 'Clear Case Magnetic',
            'tipe_hp' => 'iPhone 15',
            'harga' => 120000,
            'stok' => 10,
            'deskripsi' => 'Mendukung Magsafe, bening tidak cepat kuning.'
        ]);
    }
}