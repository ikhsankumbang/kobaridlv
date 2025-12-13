@extends('layouts.layout')

@section('title', 'barang-tambah')

@section('content')
<form action="{{ url('/barang/store') }}" method="POST">
    @csrf
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

        <label for="tambahNota" class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">TAMBAH BARANG</label>
        <hr>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">NOMER PART</label>
            <input type="text" name="no_part" class="form-control" style="display: inline-block; width: calc(100% - 110px);" placeholder="Nomer Part" value="{{ old('no_part') }}">
        </div>
        
        <div class="form-element mt-3">
            <label class="form-label" style="display: inline-block; width: 100px;">NAMA</label>            
            <input type="text" name="nama_barang" class="form-control" style="display: inline-block; width: calc(100% - 110px);" placeholder="Nama Barang" value="{{ old('nama_barang') }}">
        </div>

        <div class="form-element mt-3">
            <label class="form-label" style="display: inline-block; width: 100px;">STOK</label>
            <input type="number" name="qty" class="form-control" style="display: inline-block; width: calc(100% - 110px);" placeholder="Qty" value="{{ old('qty') }}">
        </div>

        <div class="form-element mt-3">
            <label class="form-label" style="display: inline-block; width: 100px;">HARGA</label>
            <div style="display: inline-block; width: calc(100% - 110px);">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Rp.</span>
                    </div>
                    <input type="number" name="harga" class="form-control" placeholder="10000" value="{{ old('harga') }}">
                </div>
            </div>
        </div>
        <br>
        <div class="tombol" style="text-align: right;">
            <td><a class="btn btn-danger" href="{{ url('/barang') }}">Batal</a></td>
            <td><input type="submit" class="btn btn-success" name="proses" value="Simpan"></td>
        </div>
    </div>
</form>
@endsection