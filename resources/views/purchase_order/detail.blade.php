@extends('layouts.layout')

@section('title', 'Purchase_order_detail-lihat')

@section('content')
<form action="" method="post">
    @csrf
    <div class="form">
        <label class="form-label">DETAIL PO: {{ $purchaseOrder->po_no }}</label>
        <hr>
        <a class="btn btn-danger btn-sm" href="{{ url('/purchase-order') }}">Kembali</a>
        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">PO NO</label>
            <input class="form-control" value="{{ $purchaseOrder->po_no }}" style="display: inline-block; width: calc(100% - 110px);" readonly>
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">NAMA</label>
            <input class="form-control" value="{{ $purchaseOrder->customer->nama_customer ?? '' }}" style="display: inline-block; width: calc(100% - 110px);" readonly>
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">TANGGAL</label>
            <input class="form-control" value="{{ date('d/m/Y', strtotime($purchaseOrder->tanggal)) }}" style="display: inline-block; width: calc(100% - 110px);" readonly>
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">SCHEDULE</label>
            <input class="form-control" value="{{ $purchaseOrder->schedule_delivery }}" style="display: inline-block; width: calc(100% - 110px);" readonly>
        </div>
    </div>

    <br>

    <label class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">TABEL DETAIL NOTA</label>
    <hr>
    <div class="mb-3">
        <a type="button" class="btn btn-success" href="{{ url('/purchase-order/detail/' . $purchaseOrder->po_no . '/add-form') }}">Tambah</a>
    </div>
    <table width='100%' border=1 style="text-align: center;">
        <tr class="table-primary" style="color: black; text-align: center;">
            <th>No</th>
            <th>No Part</th>
            <th>QTY Pemesanan</th>
            <th>Aksi</th>
        </tr>
        @php $index = 1; @endphp
        @foreach($purchaseOrder->details as $detail)
        <tr>
            <td>{{ $index++ }}</td>
            <td>{{ $detail->barang->nama_barang ?? $detail->no_part }}</td>
            <td>{{ number_format($detail->qty, 0, ',', '.') }}</td>
            <td>
                <a class="btn btn-danger btn-sm" href="{{ url('/purchase-order/detail/' . $purchaseOrder->po_no . '/delete/' . $detail->no_part) }}" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
        </tr>
        @endforeach
    </table>
</form>
@endsection
