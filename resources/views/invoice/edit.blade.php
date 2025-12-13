@extends('layouts.layout')

@section('title', 'Ubah Invoice')

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

    <label class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">UBAH INVOICE</label>
    <hr>

    <form action="{{ url('/invoice/update/' . $invoice->no_invoice) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 120px;">NO INVOICE</label>
            <input type="text" value="{{ $invoice->no_invoice }}" class="form-control" style="display: inline-block; width: calc(100% - 130px);" readonly>
        </div>
        
        <div class="form-element mt-3">
            <label class="form-label" style="display: inline-block; width: 120px;">TANGGAL</label>
            <input type="date" name="tanggal" class="form-control" style="display: inline-block; width: calc(100% - 130px);" value="{{ $invoice->tanggal }}">
        </div>

        <div class="form-element mt-3">
            <label class="form-label" style="display: inline-block; width: 120px;">NSFP</label>
            <input type="text" name="nsfp" class="form-control" style="display: inline-block; width: calc(100% - 130px);" value="{{ $invoice->nsfp }}">
        </div>

        <div class="form-element mt-3">
            <label class="form-label" style="display: inline-block; width: 120px;">SURAT JALAN</label>
            <div style="display: inline-block; width: calc(100% - 130px); vertical-align: top;">
                @php $selectedDoNos = $invoice->suratJalans->pluck('do_no')->toArray(); @endphp
                @foreach($suratJalans as $sj)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="do_no[]" value="{{ $sj->do_no }}" id="sj_{{ $sj->do_no }}" {{ in_array($sj->do_no, $selectedDoNos) ? 'checked' : '' }}>
                    <label class="form-check-label" for="sj_{{ $sj->do_no }}">
                        {{ $sj->do_no }} - {{ $sj->purchaseOrder->customer->nama_customer ?? '' }} (PO: {{ $sj->po_no }})
                    </label>
                </div>
                @endforeach
            </div>
        </div>

        <br>
        <div class="tombol" style="text-align: right;">
            <button type="submit" class="btn btn-success">Ubah</button>
            <a href="{{ url('/invoice') }}" class="btn btn-danger">Kembali</a>
        </div>
    </form>
</div>
@endsection
