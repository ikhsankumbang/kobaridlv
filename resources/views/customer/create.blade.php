@extends('layouts.layout')

@section('title', 'customer tambah')

@section('content')
<div class="form">
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        @foreach($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
        <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <label for="tambahNota" class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">TAMBAH PELANGGAN</label>

    <form action="{{ url('/customer/store') }}" method="POST">
        @csrf
        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">ID CUSTOMER</label>
            <input type="text" name="id_customer" class="form-control" placeholder="Id Customer" style="display: inline-block; width: calc(100% - 110px);" value="{{ old('id_customer') }}">
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">NAMA</label>            
            <input type="text" name="nama_customer" class="form-control" placeholder="Nama Customer" style="display: inline-block; width: calc(100% - 110px);" value="{{ old('nama_customer') }}">
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">ALAMAT</label>
            <input type="text" name="alamat" class="form-control" placeholder="Alamat" style="display: inline-block; width: calc(100% - 110px);" value="{{ old('alamat') }}">
        </div>         
        
        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">KONTAK</label>
            <input type="text" name="kontak" class="form-control" placeholder="Kontak" style="display: inline-block; width: calc(100% - 110px);" value="{{ old('kontak') }}">
        </div>  

        <br>
        <div class="tombol right-align" style="text-align: right;">
            <td><a class="btn btn-danger" href="{{ url('/customer') }}">Kembali</a></td>
            <td><input class="btn btn-success" type="submit" name="proses" value="Simpan"></td>
        </div>
    </form>
</div>
@endsection
