@extends('layouts.layout')

@section('title', 'pegawai-lihat')

@section('content')
<div style="text-align: end; margin-top:-25px;"><a href="{{ url('/pegawai/create') }}" class="btn btn-warning" type="button">+ TAMBAHKAN</a></div>
<div class="rectangle" style="width: 100%; margin-top: 5px;">
    <table id="example" class="table table-striped table-bordered" style="width:100%; text-align: center;">
        <thead class="table-primary">
            <tr>
                <th>ID PEGAWAI</th>
                <th>NAMA PEGAWAI</th>
                <th>JABATAN</th>
                <th>KONTAK</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pegawais as $data)
            <tr>
                <td>{{ $data->id_pegawai }}</td>
                <td style="text-align: start;">{{ $data->nama_pegawai }}</td>
                <td>{{ $data->jabatan }}</td>
                <td>{{ $data->kontak }}</td>
                <td>
                    <a class="btn btn-success" href="{{ url('/pegawai/edit/' . $data->id_pegawai) }}" role="button">Ubah</a> |
                    <a class="btn btn-danger" href="{{ url('/pegawai/delete/' . $data->id_pegawai) }}" onclick="return confirm('yakin hapus?')">Hapus</a>
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
