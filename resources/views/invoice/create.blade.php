@extends('layouts.layout')

@section('title', 'Tambah Invoice')

@section('content')
<div class="form">
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <label class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">TAMBAH INVOICE</label>
    <hr>

    <form action="{{ url('/invoice/store') }}" method="POST">
        @csrf

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 120px;">NO INVOICE</label>
            <input type="text" name="no_invoice" class="form-control" style="display: inline-block; width: calc(100% - 130px);" value="{{ old('no_invoice') }}">
        </div>
        
        <div class="form-element mt-3">
            <label class="form-label" style="display: inline-block; width: 120px;">TANGGAL</label>
            <input type="date" name="tanggal" class="form-control" style="display: inline-block; width: calc(100% - 130px);" value="{{ old('tanggal') }}">
        </div>

        <div class="form-element mt-3">
            <label class="form-label" style="display: inline-block; width: 120px;">NSFP</label>
            <input type="text" name="nsfp" class="form-control" style="display: inline-block; width: calc(100% - 130px);" value="{{ old('nsfp') }}">
        </div>

        <div class="form-element mt-3">
            <label class="form-label" style="display: inline-block; width: 120px;">SURAT JALAN</label>
            <div style="display: inline-block; width: calc(100% - 130px); vertical-align: top;">
                @foreach($suratJalans as $sj)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="do_no[]" value="{{ $sj->do_no }}" id="sj_{{ $sj->do_no }}">
                    <label class="form-check-label" for="sj_{{ $sj->do_no }}">
                        {{ $sj->do_no }} - {{ $sj->purchaseOrder->customer->nama_customer ?? '' }} (PO: {{ $sj->po_no }})
                    </label>
                </div>
                @endforeach
            </div>
        </div>

        <br>
        <div class="tombol" style="text-align: right;">
            <button type="submit" class="btn btn-success">Tambah</button>
            <a href="{{ url('/invoice') }}" class="btn btn-danger">Batal</a>
        </div>
    </form>
</div>
@endsection
