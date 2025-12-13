@extends('layouts.layout')

@section('title', 'nota-tambah')

@section('content')
<form action="{{ url('/purchase-order/store') }}" method="POST">
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

        <label for="tambahpurchase_order" class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">TAMBAH PURCHASE ORDER</label>
        <hr>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">PO NO</label>
            <input type="text" name="po_no" class="form-control" placeholder="PO NO" style="display: inline-block; width: calc(100% - 110px);" value="{{ old('po_no') }}">
        </div>
        
        <div class="form-element">
            <label for="exampleDataList" class="form-label" style="display: inline-block; width: 100px;">CUSTOMER</label>
            <select class="form-control" name="id_customer" aria-label="Default select example" style="display: inline-block; width: calc(100% - 110px);">
                <option selected disabled>---Pilih----</option>
                @foreach($customers as $customer)
                <option value="{{ $customer->id_customer }}" {{ old('id_customer') == $customer->id_customer ? 'selected' : '' }}>{{ $customer->nama_customer }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-element">
            <label for="tanggal" class="form-label" style="display: inline-block; width: 100px;">TANGGAL</label>
            <input type="date" name="tanggal" class="form-control" style="display: inline-block; width: calc(100% - 110px);" value="{{ old('tanggal') }}">
        </div>

        <div class="form-element">
            <label for="schedule_delivery" class="form-label" style="display: inline-block; width: 100px;">DELIVERY</label>
            <input type="date" name="schedule_delivery" class="form-control" style="display: inline-block; width: calc(100% - 110px);" value="{{ old('schedule_delivery') }}">
        </div>

        <br>
        <div class="tombol" style="text-align: right;">
            <button type="submit" name="proses" class="btn btn-success">Tambah</button>
            <a href="{{ url('/purchase-order') }}" class="btn btn-danger">Batal</a>
        </div>
    </div>
</form>
@endsection
