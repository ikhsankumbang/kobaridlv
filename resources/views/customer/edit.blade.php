@extends('layouts.layout')

@section('title', 'customer-ubah')

@section('content')
<form action="{{ url('/customer/update/' . $customer->id_customer) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form">
        <label for="tambahNota" class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">UBAH PELANGGAN</label>
        <hr>
        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">ID CUSTOMER</label>
            <input type="text" name="id_customer" value="{{ $customer->id_customer }}" class="form-control" style="display: inline-block; width: calc(100% - 110px);" readonly>
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">NAMA</label>
            <input type="text" name="nama_customer" value="{{ $customer->nama_customer }}" class="form-control" placeholder="Nama Customer" style="display: inline-block; width: calc(100% - 110px);">
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">ALAMAT</label>
            <input type="text" name="alamat" value="{{ $customer->alamat }}" class="form-control" placeholder="alamat" style="display: inline-block; width: calc(100% - 110px);">
        </div>
        
        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">KONTAK</label>
            <input type="kontak" name="kontak" value="{{ $customer->kontak }}" class="form-control" placeholder="kontak" style="display: inline-block; width: calc(100% - 110px);">
        </div> 
        
        <div class="tombol" style="text-align: right;">
            <td><input class="btn btn-success" type="submit" name="proses" value="Ubah Customer">
            <a class="btn btn-danger" href="{{ url('/customer') }}">kembali</a></td>
        </div>
    </div>
</form>
@endsection
