<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SuratJalanController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AuthController;

// ================== AUTH ROUTES ==================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect root to login
Route::get('/', function () {
    if (session('logged_in')) {
        return redirect('/home');
    }
    return redirect('/login');
});

// ================== PROTECTED ROUTES ==================
Route::middleware(['auth.check'])->group(function () {
    
    // Home
    Route::get('/home', [HomeController::class, 'index']);

    // ================== BARANG ==================
    Route::get('/barang', [BarangController::class, 'index']);
    Route::get('/barang/create', [BarangController::class, 'create']);
    Route::post('/barang/store', [BarangController::class, 'store']);
    Route::get('/barang/edit/{no_part}', [BarangController::class, 'edit']);
    Route::put('/barang/update/{no_part}', [BarangController::class, 'update']);
    Route::get('/barang/delete/{no_part}', [BarangController::class, 'delete']);

    // ================== CUSTOMER ==================
    Route::get('/customer', [CustomerController::class, 'index']);
    Route::get('/customer/create', [CustomerController::class, 'create']);
    Route::post('/customer/store', [CustomerController::class, 'store']);
    Route::get('/customer/edit/{id}', [CustomerController::class, 'edit']);
    Route::put('/customer/update/{id}', [CustomerController::class, 'update']);
    Route::get('/customer/delete/{id}', [CustomerController::class, 'delete']);

    // ================== PEGAWAI ==================
    Route::get('/pegawai', [PegawaiController::class, 'index']);
    Route::get('/pegawai/create', [PegawaiController::class, 'create']);
    Route::post('/pegawai/store', [PegawaiController::class, 'store']);
    Route::get('/pegawai/edit/{id}', [PegawaiController::class, 'edit']);
    Route::put('/pegawai/update/{id}', [PegawaiController::class, 'update']);
    Route::get('/pegawai/delete/{id}', [PegawaiController::class, 'delete']);

    // ================== PURCHASE ORDER ==================
    Route::get('/purchase-order', [PurchaseOrderController::class, 'index']);
    Route::get('/purchase-order/create', [PurchaseOrderController::class, 'create']);
    Route::post('/purchase-order/store', [PurchaseOrderController::class, 'store']);
    Route::get('/purchase-order/edit/{po_no}', [PurchaseOrderController::class, 'edit']);
    Route::put('/purchase-order/update/{po_no}', [PurchaseOrderController::class, 'update']);
    Route::get('/purchase-order/delete/{po_no}', [PurchaseOrderController::class, 'delete']);
    Route::get('/purchase-order/detail/{po_no}', [PurchaseOrderController::class, 'detail']);
    Route::get('/purchase-order/detail/{po_no}/add-form', [PurchaseOrderController::class, 'detailAddForm']);
    Route::post('/purchase-order/detail/{po_no}/add', [PurchaseOrderController::class, 'addDetail']);
    Route::get('/purchase-order/detail/{po_no}/delete/{no_part}', [PurchaseOrderController::class, 'deleteDetail']);
    Route::get('/purchase-order/cetak/{po_no}', [PurchaseOrderController::class, 'cetak']);

    // ================== SURAT JALAN ==================
    Route::get('/surat-jalan', [SuratJalanController::class, 'index']);
    Route::get('/surat-jalan/create', [SuratJalanController::class, 'create']);
    Route::post('/surat-jalan/store', [SuratJalanController::class, 'store']);
    Route::get('/surat-jalan/edit/{do_no}', [SuratJalanController::class, 'edit']);
    Route::put('/surat-jalan/update/{do_no}', [SuratJalanController::class, 'update']);
    Route::get('/surat-jalan/delete/{do_no}', [SuratJalanController::class, 'delete']);
    Route::get('/surat-jalan/detail/{do_no}', [SuratJalanController::class, 'detail']);
    Route::get('/surat-jalan/detail/{do_no}/add-form', [SuratJalanController::class, 'detailAddForm']);
    Route::post('/surat-jalan/detail/{do_no}/add', [SuratJalanController::class, 'addDetail']);
    Route::get('/surat-jalan/detail/{do_no}/delete/{no_part}', [SuratJalanController::class, 'deleteDetail']);
    Route::get('/surat-jalan/cetak/{do_no}', [SuratJalanController::class, 'cetak']);

    // ================== INVOICE ==================
    Route::get('/invoice', [InvoiceController::class, 'index']);
    Route::get('/invoice/create', [InvoiceController::class, 'create']);
    Route::post('/invoice/store', [InvoiceController::class, 'store']);
    Route::get('/invoice/edit/{no_invoice}', [InvoiceController::class, 'edit']);
    Route::put('/invoice/update/{no_invoice}', [InvoiceController::class, 'update']);
    Route::get('/invoice/delete/{no_invoice}', [InvoiceController::class, 'delete']);
    Route::get('/invoice/detail/{no_invoice}', [InvoiceController::class, 'detail']);
    Route::get('/invoice/cetak/{no_invoice}', [InvoiceController::class, 'cetak']);
});
