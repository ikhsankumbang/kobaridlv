<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawais = Pegawai::all();
        return view('pegawai.index', compact('pegawais'));
    }

    public function create()
    {
        return view('pegawai.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pegawai'   => 'required|max:50|unique:pegawai,id_pegawai',
            'nama_pegawai' => 'required|max:255',
            'jabatan'      => 'required|max:100',
            'kontak'       => 'required|max:50',
        ], [
            'id_pegawai.required'   => 'ID Pegawai wajib diisi!',
            'id_pegawai.unique'     => 'ID Pegawai sudah terdaftar!',
            'nama_pegawai.required' => 'Nama pegawai wajib diisi!',
            'jabatan.required'      => 'Jabatan wajib diisi!',
            'kontak.required'       => 'Kontak wajib diisi!',
        ]);

        Pegawai::create([
            'id_pegawai'   => $request->id_pegawai,
            'nama_pegawai' => $request->nama_pegawai,
            'jabatan'      => $request->jabatan,
            'kontak'       => $request->kontak,
        ]);

        return redirect('/pegawai');
    }

    public function edit($id)
    {
        $pegawai = Pegawai::where('id_pegawai', $id)->firstOrFail();
        return view('pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pegawai' => 'required|max:255',
            'jabatan'      => 'required|max:100',
            'kontak'       => 'required|max:50',
        ]);

        $pegawai = Pegawai::where('id_pegawai', $id)->firstOrFail();
        $pegawai->update([
            'nama_pegawai' => $request->nama_pegawai,
            'jabatan'      => $request->jabatan,
            'kontak'       => $request->kontak,
        ]);

        return redirect('/pegawai');
    }

    public function delete($id)
    {
        $pegawai = Pegawai::where('id_pegawai', $id)->firstOrFail();
        $pegawai->delete();
        return redirect('/pegawai');
    }
}
