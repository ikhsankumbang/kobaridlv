@extends('layouts.layout')

@section('title', 'surat_jalan-ubah')

@section('content')
<form action="{{ url('/surat-jalan/update/' . $suratJalan->do_no) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form">
        <label class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">UBAH SURAT JALAN</label>
        <hr>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">DO NO</label>
            <input type="text" value="{{ $suratJalan->do_no }}" class="form-control" style="display: inline-block; width: calc(100% - 110px);" readonly>
        </div>
        
        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">PO NO</label>
            <select class="form-control" name="po_no" style="display: inline-block; width: calc(100% - 110px);">
                @foreach($purchaseOrders as $po)
                <option value="{{ $po->po_no }}" {{ $suratJalan->po_no == $po->po_no ? 'selected' : '' }}>{{ $po->po_no }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">TANGGAL</label>
            <input type="date" name="tanggal" value="{{ $suratJalan->tanggal }}" class="form-control" style="display: inline-block; width: calc(100% - 110px);">
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">PREPARED BY</label>
            <select class="form-control" name="prepared_by" style="display: inline-block; width: calc(100% - 110px);">
                <option value="">---Pilih----</option>
                @foreach($pegawais->where('jabatan', 'preparation') as $p)
                <option value="{{ $p->id_pegawai }}" {{ $suratJalan->prepared_by == $p->id_pegawai ? 'selected' : '' }}>{{ $p->nama_pegawai }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">CHECKED BY</label>
            <select class="form-control" name="checked_by" style="display: inline-block; width: calc(100% - 110px);">
                <option value="">---Pilih----</option>
                @foreach($pegawais->where('jabatan', 'checker') as $p)
                <option value="{{ $p->id_pegawai }}" {{ $suratJalan->checked_by == $p->id_pegawai ? 'selected' : '' }}>{{ $p->nama_pegawai }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">SECURITY</label>
            <select class="form-control" name="security" style="display: inline-block; width: calc(100% - 110px);">
                <option value="">---Pilih----</option>
                @foreach($pegawais->where('jabatan', 'security') as $p)
                <option value="{{ $p->id_pegawai }}" {{ $suratJalan->security == $p->id_pegawai ? 'selected' : '' }}>{{ $p->nama_pegawai }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">DRIVER</label>
            <select class="form-control" name="driver" style="display: inline-block; width: calc(100% - 110px);">
                <option value="">---Pilih----</option>
                @foreach($pegawais->where('jabatan', 'driver') as $p)
                <option value="{{ $p->id_pegawai }}" {{ $suratJalan->driver == $p->id_pegawai ? 'selected' : '' }}>{{ $p->nama_pegawai }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">RECEIVED</label>
            <input type="text" name="received" value="{{ $suratJalan->received }}" class="form-control" style="display: inline-block; width: calc(100% - 110px);">
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">NO KENDARAAN</label>
            <input type="text" name="no_kendaraan" value="{{ $suratJalan->no_kendaraan }}" class="form-control" style="display: inline-block; width: calc(100% - 110px);">
        </div>

        <br>
        <div class="tombol" style="text-align: right;">
            <button type="submit" class="btn btn-success">Ubah</button>
            <a href="{{ url('/surat-jalan') }}" class="btn btn-danger">kembali</a>
        </div>
    </div>
</form>
@endsection
