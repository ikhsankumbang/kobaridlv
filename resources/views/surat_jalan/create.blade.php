@extends('layouts.layout')

@section('title', 'surat_jalan-tambah')

@section('content')
<form action="{{ url('/surat-jalan/store') }}" method="POST">
    @csrf
    <div class="form">
        @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
        @endif

        <label class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">TAMBAH SURAT JALAN</label>
        <hr>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">DO NO</label>
            <input type="text" name="do_no" class="form-control" placeholder="DO NO" style="display: inline-block; width: calc(100% - 110px);" value="{{ old('do_no') }}">
        </div>
        
        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">PO NO</label>
            <select class="form-control" name="po_no" style="display: inline-block; width: calc(100% - 110px);">
                <option selected disabled>---Pilih----</option>
                @foreach($purchaseOrders as $po)
                <option value="{{ $po->po_no }}">{{ $po->po_no }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">TANGGAL</label>
            <input type="date" name="tanggal" class="form-control" style="display: inline-block; width: calc(100% - 110px);" value="{{ old('tanggal') }}">
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">PREPARED BY</label>
            <select class="form-control" name="prepared_by" style="display: inline-block; width: calc(100% - 110px);">
                <option value="">---Pilih----</option>
                @foreach($pegawais->where('jabatan', 'preparation') as $p)
                <option value="{{ $p->id_pegawai }}">{{ $p->nama_pegawai }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">CHECKED BY</label>
            <select class="form-control" name="checked_by" style="display: inline-block; width: calc(100% - 110px);">
                <option value="">---Pilih----</option>
                @foreach($pegawais->where('jabatan', 'checker') as $p)
                <option value="{{ $p->id_pegawai }}">{{ $p->nama_pegawai }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">SECURITY</label>
            <select class="form-control" name="security" style="display: inline-block; width: calc(100% - 110px);">
                <option value="">---Pilih----</option>
                @foreach($pegawais->where('jabatan', 'security') as $p)
                <option value="{{ $p->id_pegawai }}">{{ $p->nama_pegawai }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">DRIVER</label>
            <select class="form-control" name="driver" style="display: inline-block; width: calc(100% - 110px);">
                <option value="">---Pilih----</option>
                @foreach($pegawais->where('jabatan', 'driver') as $p)
                <option value="{{ $p->id_pegawai }}">{{ $p->nama_pegawai }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">RECEIVED</label>
            <input type="text" name="received" class="form-control" placeholder="Received" style="display: inline-block; width: calc(100% - 110px);" value="{{ old('received') }}">
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">NO KENDARAAN</label>
            <input type="text" name="no_kendaraan" class="form-control" placeholder="No Kendaraan" style="display: inline-block; width: calc(100% - 110px);" value="{{ old('no_kendaraan') }}">
        </div>

        <br>
        <div class="tombol" style="text-align: right;">
            <button type="submit" class="btn btn-success">Tambah</button>
            <a href="{{ url('/surat-jalan') }}" class="btn btn-danger">Batal</a>
        </div>
    </div>
</form>
@endsection
