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

    // 1. Fungsi untuk menampilkan halaman form
    public function create()
    {
        return view('barang.create');
    }

    // 2. Fungsi untuk memproses data ke database
    public function store(Request $request)
    {
        // Validasi Input (Pengganti if isset dan pengecekan manual)
        $request->validate([
            'no_part'     => 'required|unique:barang,no_part', // Cek unik otomatis
            'nama_barang' => 'required',
            'qty'         => 'required|numeric',
            'harga'       => 'required|numeric',
        ], [
            // Pesan Error Custom (Opsional)
            'no_part.unique' => 'Nomer Part sudah terdaftar, pakai yang lain!',
            'no_part.required' => 'Nomer Part wajib diisi!',
        ]);

        // Simpan ke Database (Pengganti INSERT INTO)
        Barang::create([
            'no_part'     => $request->no_part,
            'nama_barang' => $request->nama_barang,
            'qty'         => $request->qty,
            'harga'       => $request->harga,
        ]);

        // Redirect kembali ke halaman index
        return redirect('/barang');
    }

    // 3. Fungsi menampilkan form edit dengan data lama
    public function edit($no_part)
    {
        // Cari barang berdasarkan no_part
        $barang = Barang::find($no_part);

        // Jika barang tidak ketemu (misal user asal ketik URL), tampilkan error 404
        if (!$barang) {
            abort(404);
        }

        // Kirim data barang ke view edit
        return view('barang.edit', compact('barang'));
    }

    // 4. Fungsi menyimpan hasil edit
    public function update(Request $request, $no_part)
    {
        $request->validate([
            'nama_barang' => 'required',
            'qty'         => 'required|numeric',
            'harga'       => 'required|numeric',
        ]);

        // Cari data yang mau diupdate
        $barang = Barang::find($no_part);
        
        // Update datanya
        $barang->update([
            'nama_barang' => $request->nama_barang,
            'qty'         => $request->qty,
            'harga'       => $request->harga,
        ]);

        // Balik ke halaman list barang
        return redirect('/barang')->with('success', 'Data berhasil diupdate!');
    }

    // 5. Fungsi untuk menghapus data
    public function destroy($no_part)
    {
        $barang = Barang::find($no_part);

        if ($barang) {
            $barang->delete();
            return redirect('/barang')->with('success', 'Data berhasil dihapus!');
        }

        return redirect('/barang')->with('error', 'Data tidak ditemukan!');
    }
}

