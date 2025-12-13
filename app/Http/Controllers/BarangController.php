<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_part'     => 'required|max:50|unique:barang,no_part',
            'nama_barang' => 'required|max:255',
            'qty'         => 'required|numeric',
            'harga'       => 'required|numeric',
        ], [
            'no_part.required'     => 'Nomer Part wajib diisi!',
            'no_part.unique'       => 'Nomer Part sudah terdaftar!',
            'nama_barang.required' => 'Nama barang wajib diisi!',
            'qty.required'         => 'Qty wajib diisi!',
            'harga.required'       => 'Harga wajib diisi!',
        ]);

        Barang::create([
            'no_part'     => $request->no_part,
            'nama_barang' => $request->nama_barang,
            'qty'         => $request->qty,
            'harga'       => $request->harga,
        ]);

        return redirect('/barang');
    }

    public function edit($no_part)
    {
        $barang = Barang::where('no_part', $no_part)->firstOrFail();
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, $no_part)
    {
        $request->validate([
            'nama_barang' => 'required|max:255',
            'qty'         => 'required|numeric',
            'harga'       => 'required|numeric',
        ]);

        $barang = Barang::where('no_part', $no_part)->firstOrFail();
        $barang->update([
            'nama_barang' => $request->nama_barang,
            'qty'         => $request->qty,
            'harga'       => $request->harga,
        ]);

        return redirect('/barang');
    }

    public function delete($no_part)
    {
        $barang = Barang::where('no_part', $no_part)->firstOrFail();
        $barang->delete();
        return redirect('/barang');
    }
}
