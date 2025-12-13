@extends('layouts.layout')

@section('title', 'barang-tambah')

@section('content')
<form action="{{ url('/barang/update/' . $barang->no_part) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form">
        <label for="tambahBarang" class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">UBAH BARANG</label>
        <hr>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">NOMER</label>            
            <input type="text" name="no_part" value="{{ $barang->no_part }}" class="form-control" style="display: inline-block; width: calc(100% - 110px);" readonly>
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">NAMA</label>            
            <input type="text" name="nama_barang" value="{{ $barang->nama_barang }}" class="form-control" style="display: inline-block; width: calc(100% - 110px);">
        </div>
        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">STOK</label>
            <input type="number" name="qty" value="{{ $barang->qty }}" class="form-control" style="display: inline-block; width: calc(100% - 110px);">
        </div>
        <div class="form-element mt-3">
            <label class="form-label" style="display: inline-block; width: 100px;">HARGA</label>
            <div style="display: inline-block; width: calc(100% - 110px);">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Rp.</span>
                    </div>
                    <input type="number" name="harga" class="form-control" placeholder="10000" value="{{ $barang->harga }}">
                </div>
            </div>
        </div>
      
        <br>
        <div class="tombol" style="text-align: right;">
            <td><input type="submit" class="btn btn-success" name="proses" value="Ubah barang">
            <a class="btn btn-danger" href="{{ url('/barang') }}">kembali</a></td>
        </div>
    </div>
</form>
@endsection