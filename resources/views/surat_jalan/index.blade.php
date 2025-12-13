@extends('layouts.layout')

@section('title', 'Surat Jalan Lihat')

@section('content')
<div style="text-align: end; margin-top:-25px;"><a href="{{ url('/surat-jalan/create') }}" class="btn btn-warning" type="button">+ TAMBAHKAN</a></div>
<div class="rectangle" style="width: 100%; margin-top: 5px;">
    <table id="example" class="table table-striped table-bordered" style="width:100%; text-align: center;">
        <thead class="table-primary">
            <tr>
                <th>DO NO</th>
                <th>PO NO</th>
                <th>TANGGAL</th>
                <th>PREPARED BY</th>
                <th>CHECKED BY</th>
                <th>SECURITY</th>
                <th>DRIVER</th>
                <th>RECEIVED</th>
                <th>NO KENDARAAN</th>
                <th>Aksi</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suratJalans as $data)
            @php
                $tanggal = date('d/m/Y', strtotime($data->tanggal));
            @endphp
            <tr>
                <td>{{ $data->do_no }}</td>
                <td>{{ $data->po_no }}</td>
                <td>{{ $tanggal }}</td>
                <td>{{ $data->preparedBy->nama_pegawai ?? '' }}</td>
                <td>{{ $data->checkedBy->nama_pegawai ?? '' }}</td>
                <td>{{ $data->securityPegawai->nama_pegawai ?? '' }}</td>
                <td>{{ $data->driverPegawai->nama_pegawai ?? '' }}</td>
                <td>{{ $data->received }}</td>
                <td>{{ $data->no_kendaraan }}</td>
                <td>
                    <a class="btn btn-success btn-sm" href="{{ url('/surat-jalan/edit/' . $data->do_no) }}">Ubah</a> |
                    <a class="btn btn-danger btn-sm" href="{{ url('/surat-jalan/delete/' . $data->do_no) }}" onclick="return confirm('yakin hapus?')">Hapus</a>
                </td>
                <td>
                    <a class="btn btn-secondary btn-sm" href="{{ url('/surat-jalan/detail/' . $data->do_no) }}">Detail</a> |
                    <a class="btn btn-primary btn-sm" href="{{ url('/surat-jalan/cetak/' . $data->do_no) }}" target="_blank">Cetak</a>
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
