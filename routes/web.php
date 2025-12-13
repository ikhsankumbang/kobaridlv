<?php

use Illuminate\Support\Facades\Route;
// 👇👇👇 BARIS INI WAJIB ADA AGAR ERROR HILANG 👇👇👇
use App\Http\Controllers\BarangController; 

use App\Http\Controllers\CustomerController;

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


// Routes Customer CRUD
Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
Route::get('/customer/create', [CustomerController::class, 'create'])->name('customer.create');
Route::post('/customer/store', [CustomerController::class, 'store'])->name('customer.store');
Route::get('/customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
Route::put('/customer/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
Route::delete('/customer/delete/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');
