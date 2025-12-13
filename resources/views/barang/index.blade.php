@extends('layouts.layout')

@section('title', 'barang-lihat')

@section('content')
<div style="text-align: end; margin-top:-25px;"><a href="{{ url('/barang/create') }}" class="btn btn-warning" type="button">+ TAMBAHKAN</a></div>
<div class="rectangle" style="width: 100%; margin-top: 5px;">
    <table id="example" class="table table-striped table-bordered" style="width:100%; text-align: center;">
        <thead class="table-primary">
            <tr>
                <th>NO PART</th>
                <th>NAMA BARANG</th>
                <th>STOK</th>
                <th>HARGA</th>
                <th>AKSI</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangs as $data)
            <tr>
                <td>{{ $data->no_part }}</td>
                <td style="text-align: start;">{{ $data->nama_barang }}</td>
                <td>{{ number_format($data->qty, 0, ',', '.') }}</td>
                <td>Rp. {{ number_format($data->harga, 0, ',', '.') }}</td>
                <td>
                    <a class="btn btn-success" href="{{ url('/barang/edit/' . $data->no_part) }}">Ubah</a> |
                    <a class="btn btn-danger" href="{{ url('/barang/delete/' . $data->no_part) }}" onclick="return confirm('yakin hapus?')">Hapus</a>
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