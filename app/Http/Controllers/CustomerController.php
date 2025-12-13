<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    // Menampilkan daftar semua customer
    public function index()
    {
        $customers = Customer::orderBy('id_customer', 'desc')->get();
        return view('customer.index', compact('customers'));
    }

    // Menampilkan form tambah customer
    public function create()
    {
        return view('customer.create');
    }

    // Menyimpan customer baru ke database
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'nama_customer' => 'required|max:255',
            'alamat'        => 'required',
            'kontak'        => 'required|max:50',
        ], [
            'nama_customer.required' => 'Nama customer wajib diisi!',
            'alamat.required'        => 'Alamat wajib diisi!',
            'kontak.required'        => 'Kontak wajib diisi!',
        ]);

        // Simpan ke Database
        Customer::create([
            'nama_customer' => $request->nama_customer,
            'alamat'        => $request->alamat,
            'kontak'        => $request->kontak,
        ]);

        return redirect('/customer')->with('success', 'Customer berhasil ditambahkan!');
    }

    // Menampilkan form edit customer
    public function edit($id)
    {
        $customer = Customer::where('id_customer', $id)->firstOrFail();
        return view('customer.edit', compact('customer'));
    }

    // Menyimpan update customer ke database
    public function update(Request $request, $id)
    {
        // Validasi Input
        $request->validate([
            'nama_customer' => 'required|max:255',
            'alamat'        => 'required',
            'kontak'        => 'required|max:50',
        ], [
            'nama_customer.required' => 'Nama customer wajib diisi!',
            'alamat.required'        => 'Alamat wajib diisi!',
            'kontak.required'        => 'Kontak wajib diisi!',
        ]);

        // Update data
        $customer = Customer::where('id_customer', $id)->firstOrFail();
        $customer->update([
            'nama_customer' => $request->nama_customer,
            'alamat'        => $request->alamat,
            'kontak'        => $request->kontak,
        ]);

        return redirect('/customer')->with('success', 'Customer berhasil diupdate!');
    }

    // Menghapus customer
    public function destroy($id)
    {
        $customer = Customer::where('id_customer', $id)->firstOrFail();
        $customer->delete();

        return redirect('/customer')->with('success', 'Customer berhasil dihapus!');
    }
}
