<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Tambahin atau pastiin baris ini ada:
    protected $fillable = ['nama', 'tipe_hp', 'harga', 'stok'];
}