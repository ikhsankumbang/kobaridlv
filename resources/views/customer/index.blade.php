@extends('layouts.layout')

@section('title', 'customer-lihat')

@section('content')
<div style="text-align: end; margin-top:-25px;"><a href="{{ url('/customer/create') }}" class="btn btn-warning" type="button">+ TAMBAHKAN</a></div>
<div class="rectangle" style="width: 100%; margin-top: 5px;">
    <table id="example" class="table table-striped table-bordered" style="width:100%; text-align: center;">
        <thead class="table-primary">
            <tr>
                <th>ID CUSTOMER</th>
                <th>NAMA</th>
                <th>ALAMAT</th>
                <th>KONTAK</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $data)
            <tr>
                <td>{{ $data->id_customer }}</td>
                <td style="text-align: start;">{{ $data->nama_customer }}</td>
                <td>{{ $data->alamat }}</td>
                <td>{{ $data->kontak }}</td>
                <td>
                    <a class="btn btn-success" href="{{ url('/customer/edit/' . $data->id_customer) }}" role="button">Ubah</a> |
                    <a class="btn btn-danger" href="{{ url('/customer/delete/' . $data->id_customer) }}" onclick="return confirm('yakin hapus?')">Hapus</a>
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
