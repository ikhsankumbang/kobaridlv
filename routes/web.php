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

use App\Http\Controllers\CustomerController;

// Routes Customer CRUD
Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
Route::get('/customer/create', [CustomerController::class, 'create'])->name('customer.create');
Route::post('/customer/store', [CustomerController::class, 'store'])->name('customer.store');
Route::get('/customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
Route::put('/customer/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
Route::delete('/customer/delete/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');
