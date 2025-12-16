@extends('layouts.layout')

@section('title', 'Invoice_detail-lihat')

@section('content')
<form action="" method="post">
    @csrf
    <div class="form">
        <label class="form-label text-center" style="font-size: large;">DETAIL INVOICE: {{ $invoice->no_invoice }}</label>
        <hr>
        <a class="btn btn-danger btn-sm" href="{{ url('/invoice') }}">Kembali</a>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 120px;">No Invoice</label>
            <input class="form-control" value="{{ $invoice->no_invoice }}" style="display: inline-block; width: calc(100% - 130px);" readonly>
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 120px;">Tanggal</label>
            <input class="form-control" value="{{ date('d/m/Y', strtotime($invoice->tanggal)) }}" style="display: inline-block; width: calc(100% - 130px);" readonly>
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 120px;">List DO</label>
            <textarea class="form-control" style="display: inline-block; width: calc(100% - 130px);" readonly>{{ $invoice->suratJalans->pluck('do_no')->implode(', ') ?: 'Tidak ada DO' }}</textarea>
        </div>

        <br>
        <label class="form-label text-center" style="font-size: large;">TABEL DETAIL BARANG</label>
        <hr>

        @php
            $grandTotal = 0;
        @endphp

        <table width='100%' border=1 style="text-align: center;">
            <tr class="table-primary" style="color: black;">
                <th>No Part</th>
                <th>Nama Barang</th>
                <th>Qty Pengiriman</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
            @foreach($invoice->suratJalans as $sj)
                @foreach($sj->details as $detail)
                @php
                    $harga = $detail->barang->harga ?? 0;
                    $total = $detail->qty_pengiriman * $harga;
                    $grandTotal += $total;
                @endphp
                <tr>
                    <td>{{ $detail->no_part }}</td>
                    <td>{{ $detail->barang->nama_barang ?? '-' }}</td>
                    <td>{{ number_format($detail->qty_pengiriman, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($harga, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            @endforeach
            <tr>
                <td colspan="4" style="text-align: center;"><strong>GRAND TOTAL</strong></td>
                <td>Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
</form>
@endsection
