@extends('layouts.layout')

@section('title', 'Purchase Order Lihat')

@section('content')
<div style="text-align: end; margin-top:-25px;"><a href="{{ url('/purchase-order/create') }}" class="btn btn-warning" type="button">+ TAMBAHKAN</a></div>
<div class="rectangle" style="width: 100%; margin-top: 5px;">
    <table id="example" class="table table-striped table-bordered" style="width:100%; text-align: center;">
        <thead class="table-primary">
            <tr>
                <th>PO NO</th>
                <th>CUSTOMER</th>
                <th>TANGGAL</th>
                <th>SCHEDULE DELIVERY</th>
                <th>Status</th>
                <th>Aksi</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchaseOrders as $data)
            @php
                $tanggal = date('d/m/Y', strtotime($data->tanggal));
            @endphp
            <tr>
                <td>{{ $data->po_no }}</td>
                <td>{{ $data->customer->nama_customer ?? '' }}</td>
                <td>{{ $tanggal }}</td>
                <td>{{ $data->schedule_delivery }}</td>
                <td>{{ $data->status ?? '' }}</td>
                <td>
                    <a class="btn btn-success" href="{{ url('/purchase-order/edit/' . $data->po_no) }}">Ubah</a> |
                    <a class="btn btn-danger" href="{{ url('/purchase-order/delete/' . $data->po_no) }}" onclick="return confirm('yakin hapus?')">Hapus</a>
                </td>
                <td>
                    <a class="btn btn-secondary" href="{{ url('/purchase-order/detail/' . $data->po_no) }}">Detail</a> 
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
