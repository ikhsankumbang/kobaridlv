<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customer.index', compact('customers'));
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_customer'   => 'required|max:50|unique:customer,id_customer',
            'nama_customer' => 'required|max:255',
            'alamat'        => 'required',
            'kontak'        => 'required|max:50',
        ], [
            'id_customer.required'   => 'ID Customer wajib diisi!',
            'id_customer.unique'     => 'ID Customer sudah terdaftar!',
            'nama_customer.required' => 'Nama customer wajib diisi!',
            'alamat.required'        => 'Alamat wajib diisi!',
            'kontak.required'        => 'Kontak wajib diisi!',
        ]);

        Customer::create([
            'id_customer'   => $request->id_customer,
            'nama_customer' => $request->nama_customer,
            'alamat'        => $request->alamat,
            'kontak'        => $request->kontak,
        ]);

        return redirect('/customer');
    }

    public function edit($id)
    {
        $customer = Customer::where('id_customer', $id)->firstOrFail();
        return view('customer.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_customer' => 'required|max:255',
            'alamat'        => 'required',
            'kontak'        => 'required|max:50',
        ]);

        $customer = Customer::where('id_customer', $id)->firstOrFail();
        $customer->update([
            'nama_customer' => $request->nama_customer,
            'alamat'        => $request->alamat,
            'kontak'        => $request->kontak,
        ]);

        return redirect('/customer');
    }

    public function delete($id)
    {
        $customer = Customer::where('id_customer', $id)->firstOrFail();
        $customer->delete();
        return redirect('/customer');
    }
}
