@extends('layouts.layout')

@section('title', 'Invoice_detail-lihat')

@section('content')
<form action="" method="post">
    @csrf
    <div class="form">
        <label class="form-label">DETAIL INVOICE: {{ $invoice->no_invoice }}</label>
        <hr>
        <a class="btn btn-danger btn-sm" href="{{ url('/invoice') }}">Kembali</a>
        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">NO INVOICE</label>
            <input class="form-control" value="{{ $invoice->no_invoice }}" style="display: inline-block; width: calc(100% - 110px);" readonly>
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">TANGGAL</label>
            <input class="form-control" value="{{ date('d/m/Y', strtotime($invoice->tanggal)) }}" style="display: inline-block; width: calc(100% - 110px);" readonly>
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">NSFP</label>
            <input class="form-control" value="{{ $invoice->nsfp }}" style="display: inline-block; width: calc(100% - 110px);" readonly>
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">SUBTOTAL</label>
            <input class="form-control" value="Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}" style="display: inline-block; width: calc(100% - 110px);" readonly>
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">PPN</label>
            <input class="form-control" value="Rp {{ number_format($invoice->ppn, 0, ',', '.') }}" style="display: inline-block; width: calc(100% - 110px);" readonly>
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">TOTAL</label>
            <input class="form-control" value="Rp {{ number_format($invoice->total_harga, 0, ',', '.') }}" style="display: inline-block; width: calc(100% - 110px);" readonly>
        </div>
    </div>

    <br>

    <label class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">TABEL DETAIL INVOICE</label>
    <hr>
    <table width='100%' border=1 style="text-align: center;">
        <tr class="table-primary" style="color: black; text-align: center;">
            <th>No</th>
            <th>DO NO</th>
            <th>Nama Barang</th>
            <th>QTY</th>
            <th>Harga</th>
            <th>Subtotal</th>
        </tr>
        @php $no = 1; @endphp
        @foreach($invoice->suratJalans as $sj)
            @foreach($sj->details as $detail)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $sj->do_no }}</td>
                <td>{{ $detail->barang->nama_barang ?? '-' }}</td>
                <td>{{ number_format($detail->qty, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($detail->barang->harga ?? 0, 0, ',', '.') }}</td>
                <td>Rp {{ number_format(($detail->barang->harga ?? 0) * $detail->qty, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        @endforeach
    </table>
</form>
@endsection
