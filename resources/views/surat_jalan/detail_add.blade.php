@extends('layouts.layout')

@section('title', 'Tambah Detail Surat Jalan')

@section('content')
<form action="{{ url('/surat-jalan/detail/' . $suratJalan->do_no . '/add') }}" method="POST">
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

        <label class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">TAMBAH DETAIL SJ: {{ $suratJalan->do_no }}</label>
        <hr>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">BARANG</label>
            <select class="form-control" name="no_part" required style="display: inline-block; width: calc(100% - 110px);">
                <option selected disabled>---Pilih----</option>
                @foreach($barangs as $barang)
                <option value="{{ $barang->no_part }}">
                    {{ $barang->no_part }} - {{ $barang->nama_barang }} - Stok: {{ $barang->stok }} - Sisa PO: {{ $barang->sisa }} - Rp {{ number_format($barang->harga, 0, ',', '.') }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">QTY</label>
            <input type="number" name="qty_pengiriman" class="form-control" placeholder="Qty Pengiriman" min="1" required style="display: inline-block; width: calc(100% - 110px);" value="{{ old('qty_pengiriman') }}">
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">KETERANGAN</label>
            <input type="text" name="keterangan" class="form-control" placeholder="Keterangan" style="display: inline-block; width: calc(100% - 110px);" value="{{ old('keterangan') }}">
        </div>

        <br>
        <div class="tombol" style="text-align: right;">
            <button type="submit" class="btn btn-success">Simpan Detail</button>
            <a href="{{ url('/surat-jalan/detail/' . $suratJalan->do_no) }}" class="btn btn-danger">Kembali</a>
        </div>
    </div>
</form>
@endsection
