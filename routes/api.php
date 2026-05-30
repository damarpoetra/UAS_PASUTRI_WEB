<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route; // <--- Ini yang kurang tadi bro

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);