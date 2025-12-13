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

// 1. Tampilkan Form Edit (mengambil data berdasarkan no_part)
Route::get('/barang/edit/{no_part}', [BarangController::class, 'edit']);

// 2. Proses Update Data (menggunakan method PUT untuk update)
Route::put('/barang/update/{no_part}', [BarangController::class, 'update']);

// Route untuk menghapus data
Route::delete('/barang/delete/{no_part}', [BarangController::class, 'destroy']);