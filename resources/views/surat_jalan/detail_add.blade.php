@extends('layouts.layout')

@section('title', 'Tambah Detail Surat Jalan')

@section('content')
<form action="{{ url('/surat-jalan/detail/' . $suratJalan->do_no . '/add') }}" method="POST">
    @csrf
    <div class="form">
        <label class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">TAMBAH DETAIL SJ: {{ $suratJalan->do_no }}</label>
        <hr>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">NO PART</label>
            <select class="form-control" name="no_part" style="display: inline-block; width: calc(100% - 110px);">
                <option selected disabled>---Pilih----</option>
                @foreach($barangs as $barang)
                <option value="{{ $barang->no_part }}">{{ $barang->nama_barang }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">QTY</label>
            <input type="number" name="qty" class="form-control" placeholder="Qty" style="display: inline-block; width: calc(100% - 110px);">
        </div>

        <br>
        <div class="tombol" style="text-align: right;">
            <button type="submit" class="btn btn-success">Tambah</button>
            <a href="{{ url('/surat-jalan/detail/' . $suratJalan->do_no) }}" class="btn btn-danger">kembali</a>
        </div>
    </div>
</form>
@endsection
