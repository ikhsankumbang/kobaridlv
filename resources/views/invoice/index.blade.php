@extends('layouts.layout')

@section('title', 'Invoice Lihat')

@section('content')
<div style="text-align: end; margin-top:-25px;"><a href="{{ url('/invoice/create') }}" class="btn btn-warning" type="button">+ TAMBAHKAN</a></div>
<div class="rectangle" style="width: 100%; margin-top: 5px;">
    <table id="example" class="table table-striped table-bordered" style="width:100%; text-align: center;">
        <thead class="table-primary">
            <tr>
                <th>NO INVOICE</th>
                <th>TANGGAL</th>
                <th>PO NO</th>
                <th>NSFP</th>
                <th>SUB TOTAL</th>
                <th>PPN</th>
                <th>TOTAL HARGA</th>
                <th>Aksi</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $data)
            @php
                $tanggal = date('d/m/Y', strtotime($data->tanggal));
                $poList = $data->suratJalans->pluck('po_no')->unique()->implode(', ');
            @endphp
            <tr>
                <td>{{ $data->no_invoice }}</td>
                <td>{{ $tanggal }}</td>
                <td>{{ $poList }}</td>
                <td>{{ $data->nsfp }}</td>
                <td>Rp {{ number_format($data->subtotal, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($data->ppn, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($data->total_harga, 0, ',', '.') }}</td>
                <td>
                    <a class="btn btn-success" href="{{ url('/invoice/edit/' . $data->no_invoice) }}">Ubah</a> |
                    <a class="btn btn-danger" href="{{ url('/invoice/delete/' . $data->no_invoice) }}" onclick="return confirm('yakin hapus?')">Hapus</a>
                </td>
                <td>
                    <a class="btn btn-secondary" href="{{ url('/invoice/detail/' . $data->no_invoice) }}">Detail</a> |
                    <a class="btn btn-primary" href="{{ url('/invoice/cetak/' . $data->no_invoice) }}" target="_blank">Cetak</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>
@endpush
