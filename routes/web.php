<?php

use Illuminate\Support\Facades\Route;
// 👇👇👇 BARIS INI WAJIB ADA AGAR ERROR HILANG 👇👇👇
use App\Http\Controllers\BarangController; 

Route::get('/', function () {
    return view('welcome');
});

// Route Barang yang tadi
Route::get('/barang', [BarangController::class, 'index']);