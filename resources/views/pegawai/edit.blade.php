@extends('layouts.layout')

@section('title', 'pegawai-ubah')

@section('content')
<form action="{{ url('/pegawai/update/' . $pegawai->id_pegawai) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form">
        <label for="ubahPegawai" class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">UBAH PEGAWAI</label>
        <hr>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">ID PEGAWAI</label>            
            <input type="text" name="id_pegawai" value="{{ $pegawai->id_pegawai }}" class="form-control" style="display: inline-block; width: calc(100% - 110px);" readonly>
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">NAMA</label>            
            <input type="text" name="nama_pegawai" value="{{ $pegawai->nama_pegawai }}" class="form-control" style="display: inline-block; width: calc(100% - 110px);">
        </div>
        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">JABATAN</label>
            <input type="text" name="jabatan" value="{{ $pegawai->jabatan }}" class="form-control" style="display: inline-block; width: calc(100% - 110px);">
        </div>
        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">KONTAK</label>
            <input type="text" name="kontak" value="{{ $pegawai->kontak }}" class="form-control" style="display: inline-block; width: calc(100% - 110px);">
        </div>
      
        <br>
        <div class="tombol" style="text-align: right;">
            <td><input type="submit" class="btn btn-success" name="proses" value="Ubah Pegawai">
            <a class="btn btn-danger" href="{{ url('/pegawai') }}">kembali</a></td>
        </div>
    </div>
</form>
@endsection
