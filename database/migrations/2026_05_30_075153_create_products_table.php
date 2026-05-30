<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('tipe_hp'); // Contoh: iPhone 13, Samsung S23
        $table->integer('harga');
        $table->integer('stok');
        $table->text('deskripsi')->nullable();
        $table->string('gambar')->nullable(); // Kita simpan nama filenya saja nanti
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
