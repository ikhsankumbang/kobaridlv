<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang; // Panggil Model Barang yang tadi dibuat

class BarangController extends Controller
{
    public function index()
    {
        // Mengambil semua data barang (sama seperti SELECT * FROM barang)
        $data_barang = Barang::all();

        // Kirim ke view (kita buat view-nya di langkah 4)
        return view('barang.index', compact('data_barang'));
    }
}