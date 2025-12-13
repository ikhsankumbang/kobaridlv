<?php

use Illuminate\Support\Facades\Route;
// 👇👇👇 BARIS INI WAJIB ADA AGAR ERROR HILANG 👇👇👇
use App\Http\Controllers\BarangController; 

Route::get('/', function () {
    return view('welcome');
});

// Route Barang yang tadi
Route::get('/barang', [BarangController::class, 'index']);

// Menampilkan Form Tambah
Route::get('/barang/create', [BarangController::class, 'create']);

// Menyimpan Data (Aksi dari tombol Simpan)
Route::post('/barang/store', [BarangController::class, 'store']);