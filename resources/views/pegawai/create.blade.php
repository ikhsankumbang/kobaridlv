@extends('layouts.layout')

@section('title', 'pegawai-tambah')

@section('content')
<form action="{{ url('/pegawai/store') }}" method="POST">
    @csrf
    <div class="form">
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            @foreach($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
            <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <label for="tambahPegawai" class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">TAMBAH PEGAWAI</label>
        <hr>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">ID PEGAWAI</label>
            <input type="text" name="id_pegawai" class="form-control" style="display: inline-block; width: calc(100% - 110px);" placeholder="Id Pegawai" value="{{ old('id_pegawai') }}">
        </div>
        
        <div class="form-element mt-3">
            <label class="form-label" style="display: inline-block; width: 100px;">NAMA</label>            
            <input type="text" name="nama_pegawai" class="form-control" style="display: inline-block; width: calc(100% - 110px);" placeholder="Nama Pegawai" value="{{ old('nama_pegawai') }}">
        </div>

        <div class="form-element mt-3">
            <label class="form-label" style="display: inline-block; width: 100px;">JABATAN</label>
            <input type="text" name="jabatan" class="form-control" style="display: inline-block; width: calc(100% - 110px);" placeholder="Jabatan" value="{{ old('jabatan') }}">
        </div>

        <div class="form-element mt-3">
            <label class="form-label" style="display: inline-block; width: 100px;">KONTAK</label>
            <input type="text" name="kontak" class="form-control" style="display: inline-block; width: calc(100% - 110px);" placeholder="Kontak" value="{{ old('kontak') }}">
        </div>
        <br>
        <div class="tombol" style="text-align: right;">
            <td><a class="btn btn-danger" href="{{ url('/pegawai') }}">Batal</a></td>
            <td><input type="submit" class="btn btn-success" name="proses" value="Simpan"></td>
        </div>
    </div>
</form>
@endsection
